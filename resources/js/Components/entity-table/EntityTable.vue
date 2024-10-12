<script setup lang="ts">
    import type { EntityInterface, IndexEntityInterface } from '../../types/entities/entity.interface';
    import { PropType } from 'vue';
    import { EntityTableHeadingInterface } from './interface';
    import EntityTableRow from './EntityTableRow.vue';
    import DataTable from 'primevue/datatable';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        headings: { type: Object as PropType<EntityTableHeadingInterface[]>, required: true },
        entities: { type: Array as PropType<EntityInterface[] & IndexEntityInterface[]>, required: true },
        kebabMenuButtonAriaContext: { type: String, required: true },
    })
</script>

<template>
    <div>
        <DataTable :value="entities" striped-rows>
            <Column v-for="heading in headings" :field="heading.field" :key="heading.field" :header="heading.heading">
                <template #body="slotProps">
                    <Link v-if="heading.isLink" :href="slotProps.data.show_url">{{ slotProps.data[heading.field] }}
                    </Link>
                    <span v-else>{{ slotProps.data[heading.field] }}</span>
                </template>
            </Column>
            <Column class="w-8 p-2 align-middle">
                <template #body="{ data }">
                    <EntityTableRow :entity="data" :fields="headings"></EntityTableRow>
                </template>
            </Column>
            <template #empty>
                <div class="text-center">No records found</div>
            </template>
        </DataTable>
    </div>
</template>