<script setup lang="ts">
    import { PropType } from 'vue';
    import TimelineLinearItemCard from '../../../Components/timeline/linear/items/TimelineLinearItemCard.vue'
    import { TimelineEntityInterface } from '../../../types/entities/timeline';
    import { NodePositionEnum } from './interface/timeline.linear.item.node-position.interface';
    defineProps({
        timelineEvents: { type: Object as PropType<TimelineEntityInterface[]>, required: true },
        campaignId: { type: Number, required: true },
    })
</script>
<template>
    <div class="flex flex-col">
        <TimelineLinearItemCard v-for="(timelineItem, key) in timelineEvents" :routeBase="'creator.campaigns.timelines'"
            :campaignId="campaignId"
            :node-position="key === 0 && timelineEvents.length === 1 ? NodePositionEnum.only : key === 0 ? NodePositionEnum.start : (key + 1) === timelineEvents.length ? NodePositionEnum.end : NodePositionEnum.both"
            :timeline="timelineItem" kebab-menu-button-aria-context="Timeline">
        </TimelineLinearItemCard>
    </div>
</template>