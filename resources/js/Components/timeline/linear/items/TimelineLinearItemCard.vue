<script setup lang="ts">
    import type { TimelineEntityInterface } from '../../../../types/entities/timeline';
    import { NodePositionEnum } from '../interface/timeline.linear.item.node-position.interface';
    import KebabMenuItemLink from '../../../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    import KebabMenuItemButton from '../../../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
    import DropDownMenu from '../../../drop-down/DropDownMenu.vue';
    import DropDownKebabIcon from '../../../drop-down/DropDownKebabIcon.vue';
    import { router } from '@inertiajs/vue3';
    import Card from 'primevue/card';

    const props = defineProps<{
        campaignId: number,
        timeline: TimelineEntityInterface
        routeBase: string,
        kebabMenuButtonAriaContext: string,
        nodePosition?: { type: NodePositionEnum, default: NodePositionEnum.only } | NodePositionEnum
    }>()

    const deleteTimeline = (timeline: TimelineEntityInterface) => {
        if (confirm('Are you sure you want to delete ' + timeline.name)) {
            router.delete(route('creator.campaigns.timelines.destroy', { campaign: props.campaignId, timeline: timeline.id }))
        }
    }
</script>
<template>
    <div class="relative w-full timeline-event">
        <div v-if="nodePosition !== NodePositionEnum.only"
            class="timline-item-line absolute left-1 md:left-2.5 w-1 -mt-2 md:-mt-5 bg-woodsmoke-300 dark:bg-woodsmoke-700 transition-colors duration-theme-change"
            :class="{ 'top-0 h-full': nodePosition === NodePositionEnum.both, 'top-2/4 h-2/4': nodePosition === NodePositionEnum.start, 'top-0 h-2/4': nodePosition === NodePositionEnum.end }">
        </div>
        <div class="flex flex-row relative w-full mb-4 md:mb-10">
            <div
                class="timeline-item-node absolute top-2/4 left-0 -translate-y-1/2 w-3 md:w-6 h-3 md:h-6 bg-woodsmoke-200 dark:bg-woodsmoke-500 rounded-full  transition-colors-and-shadow duration-theme-change">
            </div>
            <div class="relative grow ml-6 md:ml-10">
                <Card class="rounded-xl">
                    <template #header>
                        <div
                            class="flex flex-row justify-between items-center p-4 bg-biscay-100 dark:bg-biscay-900 text-xl font-bold rounded-t-xl overflow-hidden">
                            <div>{{ timeline.name }}</div>
                            <DropDownMenu :button-aria-context-name="kebabMenuButtonAriaContext + ' ' + timeline.name">
                                <template #items>
                                    <KebabMenuItemLink
                                        :href="route(routeBase + '.show', { campaign: campaignId, timeline: timeline.id })">
                                        <font-awesome-icon :icon="['fas', 'eye']" fixed-width
                                            class="mr-2"></font-awesome-icon>View
                                    </KebabMenuItemLink>
                                    <KebabMenuItemLink
                                        :href="route(routeBase + '.edit', { campaign: campaignId, timeline: timeline.id })">
                                        <font-awesome-icon :icon="['fas', 'pencil']" fixed-width
                                            class="mr-2"></font-awesome-icon>
                                        Edit
                                    </KebabMenuItemLink>
                                    <KebabMenuItemButton :func="deleteTimeline" :args="[timeline]" is-destructive>
                                        <font-awesome-icon :icon="['fas', 'trash']" fixed-width
                                            class="mr-2"></font-awesome-icon>Delete
                                    </KebabMenuItemButton>
                                </template>
                            </DropDownMenu>
                        </div>
                    </template>
                    <template #content>{{ timeline.description }}</template>
                </Card>
            </div>
        </div>
    </div>
</template>