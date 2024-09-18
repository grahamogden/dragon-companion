<script setup lang="ts">
    import { computed } from 'vue'
    import { useValidationStore } from '../../stores/validation';
    import FieldWrapper from './FieldWrapper.vue'

    const props = defineProps<{
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
        <textarea :name="props.inputName" :placeholder="props.placeholder" v-model="model"
            :aria-required="props.require" max-length="150" class="h-52 p-2 border rounded-lg duration-theme-change"
            :class="errors.length > 0 ? 'bg-alizarin-crimson-200 dark:bg-alizarin-crimson-950 border-alizarin-crimson-800 dark:border-alizarin-crimson-400' : 'bg-timberwolf-50 dark:bg-woodsmoke-950 border-woodsmoke-400 dark:border-timberwolf-50'"
            :maxlength="props.length" @focusin="validationStore.removeErrorsForField(props.inputName)"></textarea>
    </FieldWrapper>
</template>