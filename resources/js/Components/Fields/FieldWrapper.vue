<script setup lang="ts">
    import { computed } from 'vue';
    import { useValidationStore } from '../../stores/validation';

    const props = defineProps<{
        inputName: string
        error: string | undefined
        label?: string | number
        isRequired?: boolean
    }>()
    const validationStore = useValidationStore()
</script>

<template>
    <div class="flex flex-col">
        <label v-if="label !== undefined" :for="'field-' + inputName" class="mb-2">
            {{ label }}:<span v-if="isRequired"
                class="ml-1 text-alizarin-crimson-800 dark:text-alizarin-crimson-400">*</span>
        </label>
        <slot></slot>
        <div v-if="error" class="mt-2 text-sm text-alizarin-crimson-800 dark:text-alizarin-crimson-400">{{
            error
        }}
        </div>
    </div>
</template>