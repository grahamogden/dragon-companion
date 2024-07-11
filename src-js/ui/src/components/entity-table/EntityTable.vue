<script setup lang="ts">
    import { useCampaignStore } from '../../stores/campaign';
    import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface'
    import type { EntityInterface } from '../../services/entity/EntityInterface';
    import KebabMenu from '../dropdowns/kebab-menu/KebabMenu.vue';
    import type EntityTableHeadingInterface from './interface/entity-table-heading.interface';
    import type EntityTableLinkInterface from './interface/entity-table-link.interface';

    const campaignStore = useCampaignStore()

    const props = defineProps<{
        headings: EntityTableHeadingInterface[],
        entities: EntityInterface[] & Record<string, string>[],
        editLink: EntityTableLinkInterface,
        viewLink?: EntityTableLinkInterface,
        deleteConfirmationFunction: Function,
        kebabMenuButtonAriaContext: string,
    }>()
    console.debug(props.entities)
    // function confirmDelete(campaignId: number) {
    //   console.debug('Confirming delete for ' + campaignId)
    //   if (window.confirm('Are you sure you want to delete ' + campaignId + ': "' + campaignStore.getCampaignById(campaignId)?.name + '"')) {
    //     console.debug('Confirmed - attempting delete')
    //     campaignStore.deleteCampaign(campaignId)
    //   }
    // }

    // function getLinks(campaign: CampaignEntityInterface): LinkInterface[] {
    //   return [
    //     {
    //       label: 'Edit',
    //       type: LinkInterfaceTypeEnum.ROUTER,
    //       destination: {name: 'campaigns.edit', params: { externalCampaignId: campaign.id }},
    //     },
    //     {
    //       label: 'Delete',
    //       type: LinkInterfaceTypeEnum.BUTTON,
    // //       function: ((campaign.id!) => {
    // //   console.debug('Confirming delete for ' + campaignId)
    // //   if (window.confirm('Are you sure you want to delete ' + campaignId)) {
    // //     console.debug('Confirmed - attempting delete')
    // //     campaignStore.deleteCampaign(campaignId)
    // //   }
    // // })
    //       function: {
    //         func: confirmDelete,
    //         args: [campaign.id],
    //       }
    //     }
    //   ]
    // }

    function getActionLinks(campaignId: number, id: number): (DropDownItemRouter | DropDownItemButton)[] {
        return [
            new DropDownItemRouter(
                'Edit',
                { name: props.editLink.routerToName, params: { externalCampaignId: campaignId, [props.editLink.idName]: id } },
            ),
            new DropDownItemButton(
                'Delete',
                {
                    func: props.deleteConfirmationFunction,
                    args: [campaignId, id],
                }
            )
        ]
    }

</script>

<template>
    <div>
        <table class="entity-list-table">
            <thead>
                <tr>
                    <th v-for="heading in props.headings" class="capitalize">{{ heading.title }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!campaignStore.selectedCampaignId" v-for="entity in props.entities">
                    <td colspan="99">
                        <p class="text-center">Please select a campaign to get started!</p>
                    </td>
                </tr>
                <tr v-else-if="props.entities.length === 0">
                    <td colspan="99">
                        <p class="text-center">No records found. Why not add some now!</p>
                    </td>
                </tr>
                <tr v-else v-for="entity in props.entities">
                    <td v-for="field in props.headings">
                        <router-link v-if="field.isLink && props.viewLink"
                            :to="{ name: props.viewLink.routerToName, params: { externalCampaignId: campaignStore.selectedCampaignId, [props.viewLink.idName]: entity.id } }">{{
                        entity[field.title] }}</router-link>
                        <p v-else>{{ entity[field.title] }}</p>
                    </td>
                    <td class="action-cell">
                        <kebab-menu :links="getActionLinks(campaignStore.selectedCampaignId, entity.id!)"
                            :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + entity.name" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>