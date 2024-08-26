<script setup lang="ts">
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { ItemEntityInterface } from '../../services/item'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';
    import BaseInput from '../../components/fields/BaseInput.vue';

    const item = defineModel<ItemEntityInterface>('item', { required: true })

    const props = defineProps<{
        isParentLoading: boolean
    }>()

    const emit = defineEmits(['saveItem'])
    function submitForm() {
        emit('saveItem')
    }
</script>

<template>
    <loading-page :is-loading="props.isParentLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-row flex-wrap gap-default md:gap-default-md">
                <div class="w-full md:w-2/4">
                    <BaseInput type="text" inputName="name" v-model:model="item.name" label="Item Name" :require="true">
                    </BaseInput>
                </div>
                <div class="w-full">
                    <BaseInput type="text" inputName="description" v-model:model="item.description" label="Description"
                        :require="true"></BaseInput>
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'items.list' }"></EntityButtonWrapper>
            </form>
        </template>
        <template #loading-text>item</template>
    </loading-page>
</template>
