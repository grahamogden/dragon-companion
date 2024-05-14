<script setup lang="ts">
const emit = defineEmits(['updateValue'])
const props = defineProps<{
    placeholder?: string
    inputName: string
    label?: string | number
}>()

const model = defineModel()
</script>

<template>
    <div class="flex flex-col mb-4">
        <label :for="props.inputName">{{ label }}:</label>
        <input type="password" :name="props.inputName" :placeholder="props.placeholder" v-model="model" class="p-2 rounded-sm border border-dark-brown dark:border-parchment-pale rounded bg-transparent shadow-inner" />
    </div>
</template>