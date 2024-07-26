<script setup lang="ts">
    import type SelectInputOptionInterface from '../elements/interface/select-input-option.interface'
    import BaseField from './BaseField.vue'

    const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        options: SelectInputOptionInterface[],
        inputName: string,
        label?: string | number,
        require?: boolean
    }>()

    const model = defineModel<string | number | null>('model', {
        required: true,
    })
</script>

<template>
    <base-field :input-name="props.inputName" :label="props.label" :require="props.require">
        <select :name="props.inputName" :id="'field-' + props.inputName" v-model="model" :aria-required="props.require"
            class="p-2 border border-woodsmoke-900 dark:border-timberwolf-50 rounded-xl bg-timberwolf-50 dark:bg-woodsmoke-950 shadow-inner duration-500">
            <option v-for="option in props.options" :value="option.value">
                {{ option.text }}</option>
        </select>
    </base-field>
</template>