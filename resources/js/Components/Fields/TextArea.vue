<script setup lang="ts">
    import { computed } from 'vue'
    import { useValidationStore } from '../../stores/validation';
    import FieldWrapper from './FieldWrapper.vue'
    import Textarea from 'primevue/textarea';

    const props = defineProps<{
        placeholder?: string
        inputName: string
        label?: string | number
        length?: number
        require?: boolean
        error?: string
    }>()

    const model = defineModel<string | number | null | undefined>('model', {
        required: true,
    })

    const validationStore = useValidationStore()

    const errors = computed(() => validationStore.getErrorMessagesForField(props.inputName) ?? [])
</script>

<template>
    <FieldWrapper :input-name="props.inputName" :error="error" :label="props.label" :isRequired="props.require">
        <Textarea v-model="model" :name="'field-' + inputName" :id="'field-' + inputName" :invalid="!!error"></Textarea>
    </FieldWrapper>
</template>