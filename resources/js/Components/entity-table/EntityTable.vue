<script setup lang="ts">
    import { useCampaignStore } from '../../stores';
    import type { EntityInterface, IndexEntityInterface } from '../../types/entities/entity.interface';
    import KebabMenu from '../menu/wrapped-kebab-menu/KebabMenu.vue';
    import KebabMenuItemLink from '../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    import KebabMenuItemButton from '../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
    import { PropType } from 'vue';
    import { EntityTableHeadingInterface } from './interface';
    import { Link, router } from '@inertiajs/vue3';

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
        entities: { type: Object as PropType<EntityInterface[] & IndexEntityInterface[] & Record<string, string>[]>, required: true },
        kebabMenuButtonAriaContext: { type: String, required: true },
    })

    const deleteEntity = (entity: IndexEntityInterface & EntityInterface) => {
        if (entity.destroy_url) {
            if (confirm('Are you sure you want to delete this record?')) {
                router.delete(entity.destroy_url)
            }
        } else {
            alert('Nothing to delete!')
        }
    }
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
                        <Link v-if="field.isShowLink && entity.show_url" :href="entity.show_url">
                        {{ entity[field.title] }}
                        </Link>
                        <p v-else>{{ entity[field.title] }}</p>
                    </td>
                    <td class="p-0">
                        <div class="action-cell flex justify-end py-2">
                            <KebabMenu v-if="entity.edit_url || entity.destroy_url"
                                :button-aria-context-name="kebabMenuButtonAriaContext + ' ' + entity.name">
                                <template #items>
                                    <KebabMenuItemLink v-if="entity.edit_url" :href="entity.edit_url">
                                        <font-awesome-icon :icon="['fas', 'pencil']" fixed-width
                                            class="mr-2"></font-awesome-icon>Edit
                                    </KebabMenuItemLink>
                                    <!-- <KebabMenuItemLink v-if="entity.destroy_url" as="button" method="delete"
                                    :href="entity.destroy_url" :is-destructive="true">
                                    <font-awesome-icon :icon="['fas', 'trash']" fixed-width
                                        class="mr-2"></font-awesome-icon>Delete
                                </KebabMenuItemLink> -->
                                    <KebabMenuItemButton v-if="entity.destroy_url" :func="deleteEntity" :args="[entity]"
                                        is-destructive>
                                        <font-awesome-icon :icon="['fas', 'trash']" fixed-width
                                            class="mr-2"></font-awesome-icon>Delete
                                    </KebabMenuItemButton>
                                </template>
                            </KebabMenu>
                        </div>
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