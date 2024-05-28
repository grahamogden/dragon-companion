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
        <label :if="label" :for="'field-' + props.inputName" class="mb-2">{{ label }}:</label>
        <input type="text" :name="props.inputName" :id="'field-' + props.inputName" :placeholder="props.placeholder" v-model="model" class="p-2 rounded-lg border border-woodsmoke-900 dark:border-spring-wood-50 rounded bg-transparent shadow-inner" />
    </div>
</template>