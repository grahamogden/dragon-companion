<script setup lang="ts">
    import { computed } from 'vue'
    import { useValidationStore } from '../../stores/validation';
    import FieldWrapper from './FieldWrapper.vue'

    const props = defineProps<{
        type: 'text' | 'password' | 'email' | 'number'
        placeholder?: string
        inputName: string
        label?: string | number
        length?: number
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
        <input :type="props.type" :name="props.inputName" :id="'field-' + props.inputName"
            :placeholder="props.placeholder" v-model="model" :aria-required="props.require" :maxlength="props.length"
            class="p-2 rounded-lg border duration-theme-change"
            :class="errors.length > 0 ? 'bg-alizarin-crimson-200 dark:bg-alizarin-crimson-950 border-alizarin-crimson-800 dark:border-alizarin-crimson-400' : 'bg-timberwolf-50 dark:bg-woodsmoke-950 border-woodsmoke-400 dark:border-timberwolf-50'"
            @focusin="validationStore.removeErrorsForField(props.inputName)" />
    </FieldWrapper>
</template>