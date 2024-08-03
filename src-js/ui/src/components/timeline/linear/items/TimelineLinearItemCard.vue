<script setup lang="ts">
    import KebabMenu from '../../../dropdowns/kebab-menu/KebabMenu.vue';
    import { DropDownItemRouter, DropDownItemButton } from '../../../../components/interfaces/drop-down.item.interface'
    import type EntityTableHeadingInterface from '../../../entity-table/interface/entity-table-heading.interface';
    import type EntityTableLinkInterface from '../../../entity-table/interface/entity-table-link.interface';
    import type { TimelineEntityInterface } from '../../../../services/timeline';
    import { NodePositionEnum } from '../interface/timeline.linear.item.node-position.interface';

    const props = defineProps<{
        campaignId: number,
        entity: TimelineEntityInterface
        editLink: EntityTableLinkInterface,
        viewLink: EntityTableLinkInterface,
        deleteConfirmationFunction: Function,
        kebabMenuButtonAriaContext: string,
        nodePosition?: { type: NodePositionEnum, default: NodePositionEnum.both } | NodePositionEnum
    }>()

    function getActionLinks(campaignId: number, id: number): (DropDownItemRouter | DropDownItemButton)[] {
        return [
            new DropDownItemRouter(
                'View',
                { name: props.viewLink.routerToName, params: { externalCampaignId: campaignId, [props.viewLink.idName]: id } },
            ),
            new DropDownItemRouter(
                'Edit',
                { name: props.editLink.routerToName, params: { externalCampaignId: campaignId, [props.editLink.idName]: id } },
            ),
            new DropDownItemButton(
                'Delete',
                {
                    func: props.deleteConfirmationFunction,
                    args: [campaignId, id],
                },
                true
            )
        ]
    }
</script>
<template>
    <div class="relative w-full">
        <div class="timline-item-line absolute left-1 md:left-2.5 w-1 -mt-2 md:-mt-5 bg-woodsmoke-300 dark:bg-woodsmoke-700 transition-colors duration-theme-change"
            :class="{ 'top-0 h-full': props.nodePosition === NodePositionEnum.both, 'top-2/4 h-2/4': props.nodePosition === NodePositionEnum.start, 'top-0 h-2/4': props.nodePosition === NodePositionEnum.end }">
        </div>
        <div class="flex flex-row relative w-full mb-4 md:mb-10">
            <div
                class="timeline-item-node absolute top-2/4 left-0 -translate-y-1/2 w-3 md:w-6 h-3 md:h-6 bg-woodsmoke-200 dark:bg-woodsmoke-500 rounded-full shadow-sm shadow-shark-500 dark:shadow-stone-950 transition-colors-and-shadow duration-theme-change">
            </div>
            <div
                class="grid grid-cols-1 w-full ml-6 md:ml-10 rounded-lg shadow-sm shadow-shark-500 dark:shadow-stone-950 transition-colors-and-shadow duration-theme-change">
                <div
                    class="flex flex-row items-center justify-between p-2 bg-woodsmoke-200 dark:bg-woodsmoke-900 rounded-t-lg border-4 border-woodsmoke-200 dark:border-woodsmoke-900 transition-colors duration-theme-change">
                    <span class="text-lg">{{ props.entity.title }}</span>
                    <kebab-menu :links="getActionLinks(props.campaignId, props.entity.id!)"
                        :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + props.entity.title" />
                </div>
                <div
                    class="p-2 bg-timberwolf-50 dark:bg-woodsmoke-950 rounded-b-lg transition-colors duration-theme-change">
                    {{
                props.entity.body }}
                </div>
            </div>
        </div>
    </div>
</template>