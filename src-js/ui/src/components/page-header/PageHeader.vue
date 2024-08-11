<script setup lang="ts">
    import LinkButton from '../buttons/LinkButton.vue';
    import { PageHeaderLinkActionEnum, type PageHeaderLinkInterface } from './interface';

    const props = defineProps<{
        link?: PageHeaderLinkInterface,
    }>()

    const iconClass = props.link?.action === PageHeaderLinkActionEnum.EDIT ? 'pencil' : 'plus'
</script>
<template>
    <div class="flex flex-row justify-between items-center mb-6">
        <h1 class="pb-1 border-b-2 border-shark-950 dark:border-white-lilac-50 text-xl font-bold duration-500">
            <slot></slot>
        </h1>
        <LinkButton v-if="props.link" :destination="props.link.destination">
            <font-awesome-icon :icon="['fas', iconClass]" fixed-width class="mr-2" />{{ props.link.text }}
        </LinkButton>
    </div>
</template>