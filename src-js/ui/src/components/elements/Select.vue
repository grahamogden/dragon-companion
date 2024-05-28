<script setup lang="ts">

const emit = defineEmits(['updateValue'])
const props = defineProps<{
    options: Record<number | string, string>
    inputName: string
    label?: string | number
}>()

const model = defineModel()
</script>

<template>
    <div class="flex flex-col mb-4">
        <label :if="label" :for="props.inputName">{{ label }}:</label>
        <select :inputName="props.inputName" v-model="model">
            <options v-for="(optionLabel, optionValue) in props.options" :value="optionValue" class="p-2 rounded-lg border border-woodsmoke-900 dark:border-spring-wood-50 rounded bg-transparent shadow-inner">{{ optionLabel }}</options>
        </select>
    </div>
</template>