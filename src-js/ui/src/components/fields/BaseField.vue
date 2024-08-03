<script setup lang="ts">
    // import { watch } from 'vue';
    import { computed } from 'vue';
    import { useValidationStore } from '../../stores/validation';

    const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        inputName: string
        label?: string | number
        require?: boolean
    }>()

    // const errorMessages: Ref<Record<string, ValidationError>> = inject(errorMessagesKey) || ref({})

    // const errors = ref<string[]>([])

    const validationStore = useValidationStore()
    // watch(validationStore.errors, () => {
    //     errors.value = validationStore.getErrorMessagesForField(props.inputName)
    // })

    const errors = computed(() => validationStore.getErrorMessagesForField(props.inputName) ?? [])

    // watch(errorMessages, (newErrorMessages: Record<string, ValidationError>) => {
    //     errors.value = []

    //     if (!newErrorMessages) {
    //         return
    //     }

    //     const errorMessagesForInputName = newErrorMessages[props.inputName];
    //     if (!errorMessagesForInputName) {
    //         return
    //     }

    //     const keys = Object.keys(errorMessagesForInputName) as Array<keyof ValidationError>;

    //     keys.forEach((key: keyof ValidationError) => {
    //         const error = errorMessagesForInputName[key];
    //         if (error) {
    //             errors.value.push(error)
    //         }
    //     })
    // })
</script>

<template>
    <div class="flex flex-col">
        <label :if="label" :for="'field-' + props.inputName" class="mb-2">
            {{ label }}:<span v-if="props.require"
                class="ml-1 text-alizarin-crimson-800 dark:text-alizarin-crimson-400">*</span>
        </label>
        <slot></slot>
        <div v-if="errors.length > 0" class="mt-2 text-sm text-alizarin-crimson-800 dark:text-alizarin-crimson-400">{{
            errors.join(', ')
            }}
        </div>
    </div>
</template>