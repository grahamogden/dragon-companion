<script setup lang="ts">
    import { DropDownItemRouter, DropDownItemButton } from '../../../interfaces/drop-down.item.interface'
    import type EntityTableLinkInterface from '../../../entity-table/interface/entity-table-link.interface';
    import type { TimelineEntityInterface } from '../../../../types/entities/timeline';
    import { NodePositionEnum } from '../interface/timeline.linear.item.node-position.interface';
    import KebabMenuItemLink from '../../../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    import KebabMenuItemButton from '../../../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
    import DropDownMenu from '../../../drop-down/DropDownMenu.vue';
    import DropDownKebabIcon from '../../../drop-down/DropDownKebabIcon.vue';

    const props = defineProps<{
        campaignId: number,
        entity: TimelineEntityInterface
        // editLink: EntityTableLinkInterface,
        // viewLink: EntityTableLinkInterface,
        routeBase: string,
        // deleteConfirmationFunction: Function,
        kebabMenuButtonAriaContext: string,
        nodePosition?: { type: NodePositionEnum, default: NodePositionEnum.only } | NodePositionEnum
    }>()
</script>
<template>
    <div class="relative w-full">
        <div v-if="nodePosition !== NodePositionEnum.only"
            class="timline-item-line absolute left-1 md:left-2.5 w-1 -mt-2 md:-mt-5 bg-woodsmoke-300 dark:bg-woodsmoke-700 transition-colors duration-theme-change"
            :class="{ 'top-0 h-full': nodePosition === NodePositionEnum.both, 'top-2/4 h-2/4': nodePosition === NodePositionEnum.start, 'top-0 h-2/4': nodePosition === NodePositionEnum.end }">
        </div>
        <div class="flex flex-row relative w-full mb-4 md:mb-10">
            <div
                class="timeline-item-node absolute top-2/4 left-0 -translate-y-1/2 w-3 md:w-6 h-3 md:h-6 bg-woodsmoke-200 dark:bg-woodsmoke-500 rounded-full shadow-sm shadow-shark-500 dark:shadow-stone-950 transition-colors-and-shadow duration-theme-change">
            </div>
            <div
                class="grid grid-cols-1 w-full ml-6 md:ml-10 rounded-lg shadow-sm shadow-shark-500 dark:shadow-stone-950 transition-colors-and-shadow duration-theme-change">
                <div class="flex flex-row items-center justify-between p-2 bg-woodsmoke-200 dark:bg-woodsmoke-900 rounded-t-lg border-4 border-woodsmoke-200 dark:border-woodsmoke-900 transition-colors duration-theme-change"
                    :class="{ 'rounded-b-lg': !entity.description }">
                    <span class="text-lg">{{ entity.name }}</span>
                    <DropDownMenu :button-aria-context-name="kebabMenuButtonAriaContext + ' ' + entity.name">
                        <template #button-content>
                            <DropDownKebabIcon></DropDownKebabIcon>
                        </template>
                        <template #items>
                            <KebabMenuItemLink
                                :href="route(routeBase + '.show', { campaign: campaignId, timeline: entity.id })">
                                <font-awesome-icon :icon="['fas', 'eye']" fixed-width
                                    class="mr-2"></font-awesome-icon>View
                            </KebabMenuItemLink>
                            <KebabMenuItemLink
                                :href="route(routeBase + '.edit', { campaign: campaignId, timeline: entity.id })">
                                <font-awesome-icon :icon="['fas', 'pencil']" fixed-width
                                    class="mr-2"></font-awesome-icon>
                                Edit
                            </KebabMenuItemLink>
                            <KebabMenuItemLink as="button" method="delete"
                                :href="route(routeBase + '.destroy', { campaign: campaignId, timeline: entity.id })"
                                :is-destructive=true>
                                <font-awesome-icon :icon="['fas', 'trash']" fixed-width
                                    class="mr-2"></font-awesome-icon>
                                Delete
                            </KebabMenuItemLink>
                        </template>
                    </DropDownMenu>
                </div>
                <div v-if="entity.description"
                    class="p-2 bg-timberwolf-50 dark:bg-woodsmoke-950 rounded-b-lg transition-colors duration-theme-change">
                    {{ entity.description }}
                </div>
            </div>
        </div>
    </div>
</template>