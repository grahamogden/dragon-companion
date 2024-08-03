<script setup lang="ts">
    import { computed } from 'vue'
    import { useValidationStore } from '../../stores/validation';
    import type SelectInputOptionInterface from '../elements/interface/select-input-option.interface'
    import BaseField from './BaseField.vue'

    const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        options: SelectInputOptionInterface[],
        inputName: string,
        label?: string | number,
        require?: boolean
    }>()

    const model = defineModel<string | number | null>('model', {
        required: true,
    })

    const validationStore = useValidationStore()

    const errors = computed(() => validationStore.getErrorMessagesForField(props.inputName) ?? [])
</script>

<template>
    <base-field :input-name="props.inputName" :label="props.label" :require="props.require">
        <select :name="props.inputName" :id="'field-' + props.inputName" v-model="model" :aria-required="props.require"
            class="px-2 py-2.5 pb-2 border rounded-xl shadow-inner duration-theme-change"
            :class="errors.length > 0 ? 'bg-alizarin-crimson-200 dark:bg-alizarin-crimson-950 border-alizarin-crimson-800 dark:border-alizarin-crimson-400' : 'bg-timberwolf-50 dark:bg-woodsmoke-950 border-woodsmoke-200 dark:border-timberwolf-50'"
            @focusin="validationStore.removeErrorsForField(props.inputName)">
            <option v-for="option in props.options" :value="option.value">
                {{ option.text }}</option>
        </select>
        <!-- <div
            class="relative w-full border border-woodsmoke-900 dark:border-timberwolf-50 rounded-xl bg-timberwolf-50 dark:bg-woodsmoke-950 shadow-inner overflow-hidden duration-theme-change">
            <select :name="props.inputName" :id="'field-' + props.inputName" v-model="model"
                :aria-required="props.require" class="p-2 py-2.5 w-full bg-transparent">
                <option v-for="option in props.options" :value="option.value">
                    {{ option.text }}</option>
            </select>
        </div> -->
    </base-field>
</template>