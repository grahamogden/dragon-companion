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
        <input type="password" :name="props.inputName" :placeholder="props.placeholder" v-model="model" class="p-2 border border-woodsmoke-950 dark:border-timberwolf-50 rounded-xl bg-timberwolf-50 dark:bg-shark-950 shadow-inner" />
    </div>
</template>