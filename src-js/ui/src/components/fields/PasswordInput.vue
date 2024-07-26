<script setup lang="ts">
    import BaseField from './BaseField.vue'

    const emit = defineEmits(['updateValue'])
    const props = defineProps<{
        placeholder?: string
        inputName: string
        label?: string | number
        length?: number
        require?: boolean
    }>()

    const model = defineModel<string>('model', {
        required: true,
    })
</script>

<template>
    <base-field :input-name="props.inputName" :label="props.label" :require="props.require">
        <input type="password" :name="props.inputName" :id="'field-' + props.inputName" :placeholder="props.placeholder"
            v-model="model" :aria-required="props.require" :maxlength="props.length"
            class="p-2 bg-timberwolf-50 dark:bg-woodsmoke-950 rounded-xl border border-woodsmoke-900 dark:border-timberwolf-50 shadow-inner duration-500" />
    </base-field>
</template>