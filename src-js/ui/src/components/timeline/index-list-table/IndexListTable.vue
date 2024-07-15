<script setup lang="ts">
    import { useCampaignStore } from '../../../stores/campaign'
    import type EntityTableHeadingInterface from '../../entity-table/interface/entity-table-heading.interface';
    import type EntityTableLinkInterface from '../../entity-table/interface/entity-table-link.interface';
    import TimelineTableRow from '../TimelineTableRow.vue'
    import type { TimelineEntityInterface } from '../../../services/timeline';

    const campaignStore = useCampaignStore()

    const props = defineProps<{
        campaignId: number,
        headings: EntityTableHeadingInterface[],
        entities: TimelineEntityInterface[] & Record<string, string>[],
        editLink: EntityTableLinkInterface,
        viewLink?: EntityTableLinkInterface,
        deleteConfirmationFunction: Function,
        kebabMenuButtonAriaContext: string,
    }>()
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
                <timeline-table-row v-for="entity in props.entities" :entity="entity"
                    :campaign-id="props.campaignId" :headings="props.headings"
                    :view-link="props.viewLink" :edit-link="props.editLink"
                    :delete-confirmation-function="props.deleteConfirmationFunction"
                    :kebab-menu-button-aria-context="props.kebabMenuButtonAriaContext"></timeline-table-row>
                <!-- <tr v-else v-for="entity in props.entities">
                    <td v-for="field in props.headings">
                        <router-link v-if="field.isLink && props.viewLink" :to="{ name: props.viewLink.routerToName, params: { externalCampaignId: campaignStore.selectedCampaignId, [props.viewLink.idName]: entity.id } }">{{
                        entity[field.title] }}</router-link>
                        <p v-else>{{ entity[field.title] }}</p>
                    </td>
                    <td class="action-cell">
                        <kebab-menu :links="getActionLinks(campaignStore.selectedCampaignId, entity.id!)"
                            :button-aria-context-name="props.kebabMenuButtonAriaContext + ' ' + entity.name" />
                    </td>
                </tr> -->
            </tbody>
        </table>
    </div>
</template>