<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import type PaginationInterface from '../../types/pagination/pagination.interface';

    defineProps<{
        pagination: PaginationInterface<object> | undefined,
    }>()

</script>
<template>
    <div class="flex justify-end">
        <div v-for="paginate in pagination?.links ?? []">
            <Link v-if="paginate.active && paginate.url" :href="paginate.url"
                class="inline-block px-2 py-1 hover:bg-biscay-600 focus:bg-biscay-600 rounded border border-biscay-500"
                v-html="paginate.label">
            </Link>
            <span v-else
                class="inline-block px-2 py-1 hover:bg-stone-600 focus:bg-stone-600 rounded border border-stone-500"
                v-html="paginate.label"></span>
        </div>
    </div>
</template>