<script setup lang="ts">
    import { computed } from 'vue';
    import { useValidationStore } from '../../stores/validation';

    const props = defineProps<{
        inputName: string
        label?: string | number
        require?: boolean
    }>()
    const validationStore = useValidationStore()

    const errors = computed(() => validationStore.getErrorMessagesForField(props.inputName) ?? [])
</script>

<template>
    <div class="flex flex-col">
        <label v-if="label !== undefined" :for="'field-' + props.inputName" class="mb-2">
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