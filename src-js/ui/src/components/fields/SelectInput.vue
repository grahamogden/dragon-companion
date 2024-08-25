<script setup lang="ts">
    import { computed } from 'vue'
    import { useValidationStore } from '../../stores/validation';
    import type SelectInputOptionInterface from '../elements/interface/select-input-option.interface'
    import FieldWrapper from './FieldWrapper.vue'

    // const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        options: SelectInputOptionInterface[],
        inputName: string,
        label?: string | number,
        require?: boolean
    }>()

    const model = defineModel<string | number | null | undefined>('model', {
        required: true,
    })

    const validationStore = useValidationStore()

    const errors = computed(() => validationStore.getErrorMessagesForField(props.inputName) ?? [])
</script>

<template>
    <FieldWrapper :input-name="props.inputName" :label="props.label" :require="props.require">
        <select :name="props.inputName" :id="'field-' + props.inputName" v-model="model" :aria-required="props.require"
            class="px-2 py-2.5 border rounded-lg duration-theme-change"
            :class="errors.length > 0 ? 'bg-alizarin-crimson-200 dark:bg-alizarin-crimson-950 border-alizarin-crimson-800 dark:border-alizarin-crimson-400' : 'bg-timberwolf-50 dark:bg-woodsmoke-950 border-woodsmoke-400 dark:border-timberwolf-50'"
            @focusin="validationStore.removeErrorsForField(props.inputName)">
            <option v-for="option in props.options" :value="option.value">
                {{ option.text }}</option>
        </select>
    </FieldWrapper>
</template>