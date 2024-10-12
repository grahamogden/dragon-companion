<script setup lang="ts">
    import { useValidationStore } from '../../stores/validation';
    import FieldWrapper from './FieldWrapper.vue'

    const props = defineProps<{
        type: 'text' | 'email' | 'number'
        inputName: string
        error: string | undefined
        placeholder?: string
        label?: string | number
        length?: number
        isRequired?: boolean
        disabled?: boolean
    }>()

    const model = defineModel<string | number | null | undefined>('model', {
        required: true,
    })

    const validationStore = useValidationStore()
</script>

<template>
    <FieldWrapper :input-name="inputName" :error="error" :label="label" :isRequired="isRequired">
        <input :type="type" :name="inputName" :id="'field-' + inputName" :placeholder="placeholder" v-model="model"
            :aria-required="isRequired" :maxlength="length" class="p-2 rounded-lg border duration-theme-change"
            :class="{ 'bg-alizarin-crimson-200 dark:bg-alizarin-crimson-950 border-alizarin-crimson-800 dark:border-alizarin-crimson-400': error, 'bg-timberwolf-50 dark:bg-woodsmoke-950 border-woodsmoke-400 dark:border-timberwolf-50': !error, 'bg-stone-200 dark:bg-stone-700 text-stone-400 cursor-not-allowed': disabled }"
            :disabled="disabled" @focusin="validationStore.removeErrorsForField(inputName)" />
    </FieldWrapper>
</template>