<script setup lang="ts">
    import { useCampaignStore } from '../../stores';
    import { DropDownItemRouter, DropDownItemButton } from '../interfaces/drop-down.item.interface'
    import type { EntityInterface } from '../../types/entities/entity.interface';
    import KebabMenu from '../menu/wrapped-kebab-menu/KebabMenu.vue';
    import KebabMenuItemLink from '../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    import KebabMenuItemButton from '../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
    import { PropType } from 'vue';
    import { EntityTableHeadingInterface, EntityTableItemInterface } from './interface';
    import { Link } from '@inertiajs/vue3';

    const campaignStore = useCampaignStore()

    // const props = defineProps<{
    //     headings: EntityTableHeadingInterface[],
    //     entities: EntityInterface[] & Record<string, string>[],
    //     editLink: EntityTableLinkInterface,
    //     viewLink?: EntityTableLinkInterface,
    //     deleteConfirmationFunction: Function,
    //     kebabMenuButtonAriaContext: string,
    // }>()
    defineProps({
        headings: { type: Object as PropType<EntityTableHeadingInterface[]>, required: true },
        entities: { type: Object as PropType<EntityTableItemInterface[] & Record<string, string>[]>, required: true },
        kebabMenuButtonAriaContext: { type: String, required: true }
    })
</script>

<template>
    <div>
        <table class="entity-list-table">
            <thead>
                <tr>
                    <th v-for="heading in headings" class="p-2 capitalize">{{ heading.title }}</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="entities.length > 0 && campaignStore.selectedCampaignId !== null" v-for="entity in entities">
                    <td v-for="field in headings" class="p-2">
                        <Link v-if="field.isLink && entity.view_url" :href="entity.view_url">
                        {{
                            entity[field.title] }}</Link>
                        <p v-else>{{ entity[field.title] }}</p>
                    </td>
                    <td class="action-cell flex justify-end py-2">
                        <KebabMenu :button-aria-context-name="kebabMenuButtonAriaContext + ' ' + entity.name">
                            <template #items>
                                <KebabMenuItemLink :href="entity.edit_url">
                                    <font-awesome-icon :icon="['fas', 'pencil']" fixed-width
                                        class="mr-2"></font-awesome-icon>Edit
                                </KebabMenuItemLink>
                                <KebabMenuItemLink as="button" method="delete" :href="entity.delete_url"
                                    :is-destructive="true">
                                    <font-awesome-icon :icon="['fas', 'trash']" fixed-width
                                        class="mr-2"></font-awesome-icon>Delete
                                </KebabMenuItemLink>
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