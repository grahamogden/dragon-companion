<script setup lang="ts">
    import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface'
    import KebabMenu from '../menu/wrapped-kebab-menu/KebabMenu.vue';
    import type EntityTableHeadingInterface from '../entity-table/interface/entity-table-heading.interface';
    import type EntityTableLinkInterface from '../entity-table/interface/entity-table-link.interface';
    import { TimelineEntity } from '../../services/timeline'

    const props = defineProps<{
        campaignId: number,
        headings: EntityTableHeadingInterface[],
        entity: TimelineEntity & Record<string, string>,
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
    <tr>
        <td v-for="field in props.headings">
            <router-link v-if="field.isLink && props.viewLink" :to="{
                name: props.viewLink.routerToName,
                params: {
                    externalCampaignId: props.campaignId,
                    [props.viewLink.idName]: entity.id
                }
            }">{{ entity[field.title] }}</router-link>
            <p v-else>{{ entity[field.title] }}</p>
        </td>
        <td class="action-cell text-right py-1 align-middle">
            <kebab-menu :links="getActionLinks(props.campaignId, entity.id!)"
                :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + entity.name" />
        </td>
    </tr>
    <tr v-for="childTimelines in props.entity.child_timelines"
        class="bg-woodsmoke-200/50 dark:bg-woodsmoke-700/25 transition-colors duration-theme-change">
        <td v-for="field in props.headings">
            <router-link v-if="field.isLink && props.viewLink" :to="{
                name: props.viewLink.routerToName,
                params: {
                    externalCampaignId: props.campaignId,
                    [props.viewLink.idName]: childTimelines.id
                }
            }">{{ childTimelines[field.title] }}</router-link>
            <p v-else>{{ childTimelines[field.title] }}</p>
        </td>
        <td class="action-cell text-right py-1 align-middle">
            <kebab-menu :links="getActionLinks(props.campaignId, childTimelines.id!)"
                :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + childTimelines.title" />
        </td>
    </tr>
    <tr>
        <td class="bg-woodsmoke-200/50 dark:bg-woodsmoke-700/25 text-center transition-colors duration-theme-change"
            colspan="99"><router-link
                :to="{ name: 'timelines.add', params: { externalCampaignId: props.campaignId }, query: { parentId: props.entity.id } }">Add
                a new children timeline record</router-link></td>
    </tr>
</template>