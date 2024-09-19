<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import type PaginationInterface from '../../types/pagination/pagination.interface';

    defineProps<{
        pagination: PaginationInterface<object> | undefined,
    }>()

</script>
<template>
    <div class="flex justify-end">
        <div v-for="paginate in pagination?.links ?? []"
            class="hover:bg-biscay-600 focus:bg-biscay-600 border-t border-b border-l last:border-r border-biscay-500 first:rounded-l last:rounded-r"
            :class="{ 'cursor-not-allowed': !paginate.active }">
            <Link v-if="paginate.active && paginate.url" :href="paginate.url" class="inline-block px-2 py-1"
                v-html="paginate.label">
            </Link>
            <span v-else class="inline-block px-2 py-1" v-html="paginate.label"></span>
        </div>
    </div>
</template>