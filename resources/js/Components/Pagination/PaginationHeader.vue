<script setup lang="ts">
    import { PropType } from 'vue';
    import PaginationInterface from '../../types/pagination/pagination.interface';
    import Pagination from './Pagination.vue';

    defineProps({ pagination: Object as PropType<PaginationInterface<Object>>, })
</script>
<template>
    <div class="mb-default md:mb-default-md">
        <Pagination :pagination="pagination"></Pagination>
    </div>
</template>