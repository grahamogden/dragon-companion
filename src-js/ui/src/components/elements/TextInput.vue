<script setup lang="ts">
const emit = defineEmits(['updateValue'])
const props = defineProps<{
    placeholder?: string
    inputName: string
    label?: string | number
}>()

const model = defineModel()
</script>

<template>
    <div class="flex flex-col mb-4">
        <label :if="label" :for="'field-' + props.inputName" class="mb-2"><slot>{{ label }}</slot>:</label>
        <input type="text" :name="props.inputName" :id="'field-' + props.inputName" :placeholder="props.placeholder" v-model="model" class="p-2 border border-woodsmoke-900 dark:border-timberwolf-50 rounded-xl bg-timberwolf-50 dark:bg-woodsmoke-950 shadow-inner duration-500" />
    </div>
</template>