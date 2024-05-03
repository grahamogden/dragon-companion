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
            <options v-for="(optionLabel, optionValue) in props.options" :value="optionValue">{{ optionLabel }}</options>
        </select>
    </div>
</template>