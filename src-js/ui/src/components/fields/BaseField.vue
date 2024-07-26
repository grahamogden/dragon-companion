<script setup lang="ts">
    import { watch } from 'vue';
    import type ValidationError from '../../services/repository/errors/ValidationError';
    import { inject } from 'vue';
    import { errorMessagesKey } from '../../keys';
    import type { Ref } from 'vue';
    import { ref } from 'vue';

    const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        inputName: string
        label?: string | number
        require?: boolean
    }>()

    const errorMessages: Ref<Record<string, ValidationError>> = inject(errorMessagesKey) || ref({})

    const errors = ref<string[]>([])

    watch(errorMessages, (newErrorMessages: Record<string, ValidationError>) => {
        errors.value = []

        if (!newErrorMessages) {
            return
        }

        const errorMessagesForInputName = newErrorMessages[props.inputName];
        if (!errorMessagesForInputName) {
            return
        }

        const keys = Object.keys(errorMessagesForInputName) as Array<keyof ValidationError>;

        keys.forEach((key: keyof ValidationError) => {
            const error = errorMessagesForInputName[key];
            if (error) {
                errors.value.push(error)
            }
        })
    })
</script>

<template>
    <div class="flex flex-col px-4 pb-4"
        :class="{ 'has-error': errors.length, 'bg-alizarin-crimson-500/30': errors.length, 'pt-2': errors.length }">
        <label :if="label" :for="'field-' + props.inputName" class="mb-2">
            {{ label }}:<span v-if="props.require" class="text-red-700">*</span>
        </label>
        <slot></slot>
        <div v-if="errors.length > 0" class="mt-2 text-sm">{{ errors.join(', ') }}
        </div>
    </div>
</template>