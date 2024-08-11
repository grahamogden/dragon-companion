<script setup lang="ts">
    import TextInput from '../../components/fields/TextInput.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { ItemEntityInterface } from '../../services/item'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';

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
            <form @submit.prevent="submitForm" class="flex flex-row flex-wrap gap-6">
                <div class="w-full md:w-2/4">
                    <TextInput inputName="name" v-model:model="item.name" label="Item Name" :require="true" />
                </div>
                <div class="w-full">
                    <TextInput inputName="description" v-model:model="item.description" label="Description"
                        :require="true" />
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'items.list' }" />
            </form>
        </template>
        <template #loading-text>item</template>
    </loading-page>
</template>
