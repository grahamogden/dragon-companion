<script setup lang="ts">
    import { DropDownItemRouter, DropDownItemButton } from '../../../components/interfaces/drop-down.item.interface'
    import KebabMenu from '../../dropdowns/kebab-menu/KebabMenu.vue';
    import type EntityTableHeadingInterface from '../../entity-table/interface/entity-table-heading.interface';
    import type EntityTableLinkInterface from '../../entity-table/interface/entity-table-link.interface';
    import TimelineEntity from '../../../services/timeline/TimelineEntity'

    const props = defineProps<{
        campaignId: number,
        timelineId: number,
        headings: EntityTableHeadingInterface[],
        entities: TimelineEntity[] & Record<string, string>[],
        editLink: EntityTableLinkInterface,
        viewLink?: EntityTableLinkInterface,
        deleteConfirmationFunction: Function,
        kebabMenuButtonAriaContext: string,
    }>()

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
                },
                true
            )
        ]
    }
</script>

<template>
    <div>
        <table class="table-rounded">
            <thead class="table-heading-dark">
                <tr>
                    <th v-for="heading in props.headings" class="capitalize">{{ heading.title }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="props.entities.length === 0">
                    <td colspan="99">
                        <p class="text-center">No records found. Why not add some now!</p>
                    </td>
                </tr>
                <tr v-else v-for="entity in props.entities">
                    <td v-for="field in props.headings">
                        <router-link v-if="field.isLink && props.viewLink"
                            :to="{ name: props.viewLink.routerToName, params: { externalCampaignId: props.campaignId, [props.viewLink.idName]: entity.id } }">{{
                        entity[field.title] }}</router-link>
                        <p v-else>{{ entity[field.title] }}</p>
                    </td>
                    <td class="action-cell">
                        <kebab-menu :links="getActionLinks(props.campaignId, entity.id!)"
                            :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + entity.name" />
                    </td>
                </tr>
                <tr>
                    <td class="bg-woodsmoke-200/50 dark:bg-woodsmoke-700/50 text-center duration-500" colspan="99">
                        <router-link
                            :to="{ name: 'timelines.add', params: { externalCampaignId: props.campaignId }, query: { parentId: timelineId } }">Add
                            a children timeline record</router-link></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>