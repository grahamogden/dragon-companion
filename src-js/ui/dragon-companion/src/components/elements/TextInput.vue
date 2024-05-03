<script setup lang="ts">
const emit = defineEmits(['updateValue'])
const props = defineProps<{
    // inputValue: string | number
    placeholder?: string
    inputName: string
    label?: string | number
}>()

const model = defineModel()
</script>

<template>
    <div class="flex flex-col mb-4">
        <label :if="label" :for="'field-' + props.inputName">{{ label }}:</label>
        <input type="text" :name="props.inputName" :id="'field-' + props.inputName" :placeholder="props.placeholder" v-model="model" class="p-2 rounded-sm border border-dark-brown dark:border-parchment-pale rounded bg-transparent shadow-inner" />
    </div>
</template>