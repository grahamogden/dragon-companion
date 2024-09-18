<script setup lang="ts">
    import { useCampaignStore } from '../../../../cakephp/src-ui/src/stores/campaign';
    import { DropDownItemRouter, DropDownItemButton } from '../interfaces/drop-down.item.interface'
    import type { EntityInterface } from '../../types/entities/entity.interface';
    import KebabMenu from '../menu/wrapped-kebab-menu/KebabMenu.vue';
    import type EntityTableHeadingInterface from './interface/entity-table-heading.interface';
    import type EntityTableLinkInterface from './interface/entity-table-link.interface';
    import KebabMenuItemLink from '../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    import KebabMenuItemButton from '../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';

    const campaignStore = useCampaignStore()

    const props = defineProps<{
        headings: EntityTableHeadingInterface[],
        entities: EntityInterface[] & Record<string, string>[],
        editLink: EntityTableLinkInterface,
        viewLink?: EntityTableLinkInterface,
        deleteConfirmationFunction: Function,
        kebabMenuButtonAriaContext: string,
    }>()

    function getActionLinks(campaignId: number, id: number): (DropDownItemRouter | DropDownItemButton)[] {
        return [
            new DropDownItemRouter(
                '<i class="fa fa-pencil mr-2" aria-hidden="true"></i>Edit',
                { name: props.editLink.routerToName, params: { externalCampaignId: campaignId, [props.editLink.idName]: id } },
            ),
            new DropDownItemButton(
                '<i class="fa fa-trash mr-2" aria-hidden="true"></i>Delete',
                {
                    func: props.deleteConfirmationFunction,
                    args: [campaignId, id],
                },
                true,
            )
        ]
    }
</script>

<template>
    <div>
        <table class="entity-list-table">
            <thead>
                <tr>
                    <th v-for="heading in props.headings" class="p-2 capitalize">{{ heading.title }}</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="props.entities.length > 0 && campaignStore.selectedCampaignId !== null"
                    v-for="entity in props.entities">
                    <td v-for="field in props.headings" class="p-2">
                        <RouterLink v-if="field.isLink && props.viewLink"
                            :to="{ name: props.viewLink.routerToName, params: { externalCampaignId: campaignStore.selectedCampaignId, [props.viewLink.idName]: entity.id } }">
                            {{
                                entity[field.title] }}</RouterLink>
                        <p v-else>{{ entity[field.title] }}</p>
                    </td>
                    <td class="action-cell flex justify-end py-2">
                        <KebabMenu :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + entity.name">
                            <template #items>
                                <KebabMenuItemLink
                                    :href="{ name: props.editLink.routerToName, params: { externalCampaignId: campaignStore.selectedCampaignId, [props.editLink.idName]: entity.id } }">
                                    <font-awesome-icon :icon="['fas', 'pencil']" fixed-width
                                        class="mr-2"></font-awesome-icon>Edit
                                </KebabMenuItemLink>
                                <KebabMenuItemButton :func="props.deleteConfirmationFunction"
                                    :args="[campaignStore.selectedCampaignId, entity.id]" :is-destructive="true">
                                    <font-awesome-icon :icon="['fas', 'trash']" fixed-width
                                        class="mr-2"></font-awesome-icon>Delete
                                </KebabMenuItemButton>
                            </template>
                        </KebabMenu>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="99">
                        <p class="text-center">No records found. Why not add some now!</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>