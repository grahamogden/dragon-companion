<script setup lang="ts">
    import { useCampaignStore } from '../../stores/campaign';
    import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface'
    import type { EntityInterface } from '../../services/entity/EntityInterface';
    import KebabMenu from '../dropdowns/kebab-menu/KebabMenu.vue';

    const campaignStore = useCampaignStore()

    const props = defineProps<{
        headings: string[]
        entities: EntityInterface[] & Record<string, string>[]
        link: {
            name: string,
            idName: string,
        }
        deleteConfirmationFunction: Function,
        ariaContext: string,
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

    function getLinks(campaignId: number, id: number): (DropDownItemRouter | DropDownItemButton)[] {
        return [
            new DropDownItemRouter(
                'Edit',
                { name: props.link.name, params: { externalCampaignId: campaignId, [props.link.idName]: id } },
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
                    <th v-for="heading in props.headings" class="capitalize">{{ heading }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="campaignStore.selectedCampaignId" v-for="entity in props.entities">
                    <td v-for="field in props.headings"><router-link
                            :to="{ name: props.link?.name, params: { externalCampaignId: campaignStore.selectedCampaignId, [props.link.idName]: entity.id } }">{{
                        entity[field] }}</router-link></td>
                    <td class="action-cell">
                        <!-- <KebabMenu :links="getLinks(campaign)" /> -->
                        <!-- <div> -->
                        <!-- <router-link :to="{ name: 'campaigns.edit', params: { externalCampaignId: campaign.id }}">Edit</router-link> -->
                        <!-- </div> -->
                        <!-- <div> -->
                        <!-- <button class="destructive-button" @click="confirmDelete(campaign.id!)">Delete</button> -->
                        <!-- </div> -->
                        <kebab-menu :links="getLinks(campaignStore.selectedCampaignId, entity.id!)"
                            :button-aria-context-name="props.ariaContext+ ' ' + entity.name" />
                    </td>
                </tr>
                <tr v-if="props.entities.length === 0">
                    <td colspan="99">
                        <p class="text-center">No records found. Why not add some now!</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>