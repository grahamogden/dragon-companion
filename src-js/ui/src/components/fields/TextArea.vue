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
        <textarea :name="props.inputName" :placeholder="props.placeholder" v-model="model"
            :aria-required="props.require" max-length="150"
            class="h-52 p-2 border border-woodsmoke-900 dark:border-timberwolf-50 rounded-xl bg-timberwolf-50 dark:bg-woodsmoke-950 shadow-inner duration-500"
            :maxlength="props.length"></textarea>
    </base-field>
</template>