<script setup lang="ts">
    import { SelectInputOptionInterface } from '../../types/entity-option';
    import FieldWrapper from './FieldWrapper.vue'

    const props = defineProps<{
        options: SelectInputOptionInterface[]
        inputName: string
        label?: string | number
        isRequired?: boolean
        error?: string
        inlcudeNullValue?: boolean
        editable?: boolean
    }>()

    if (props.inlcudeNullValue) {
        props.options.unshift({ text: '-', value: null })
    }

    const model = defineModel<string | number | null | undefined>('model', {
        required: true,
    })
</script>

<template>
    <FieldWrapper :input-name="inputName" :error="error" :label="label" :isRequired="isRequired">
        <select :name="inputName" :id="'field-' + inputName" v-model="model" :aria-required="isRequired"
            class="px-2 py-2 border rounded-lg duration-theme-change"
            :class="!!error ? 'bg-alizarin-crimson-200 dark:bg-alizarin-crimson-950 border-alizarin-crimson-800 dark:border-alizarin-crimson-400' : 'bg-timberwolf-50 dark:bg-woodsmoke-950 border-woodsmoke-400 dark:border-timberwolf-50'">
            <option v-for="option in options" :value="option.value">
                {{ option.text }}</option>
        </select>
    </FieldWrapper>
</template>