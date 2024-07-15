<script setup lang="ts">
    import type SelectInputOptionInterface from './interface/select-input-option.interface'

    const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        options: SelectInputOptionInterface[],
        inputName: string,
        label?: string | number,
    }>()
    // console.debug(props.options)

    const model = defineModel()
</script>

<template>
    <div class="flex flex-col mb-4">
        <label :if="label" :for="'field-' + props.inputName" class="mb-2">{{ label }}:</label>
        <select class="px-2 py-3 border border-woodsmoke-900 dark:border-timberwolf-50 rounded-xl bg-timberwolf-50 dark:bg-woodsmoke-950 shadow-inner duration-500" v-model="model" :name="props.inputName" :id="'field-' + props.inputName">
            <option v-for="option in props.options" :value="option.value">
                {{ option.text }}</option>
        </select>
    </div>
</template>