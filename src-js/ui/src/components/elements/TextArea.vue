<script setup lang="ts">
const emit = defineEmits(['updateValue'])
const props = defineProps<{
    placeholder?: string
    inputName: string
    label?: string | number
    length?: number
}>()

const model: any = defineModel()
</script>

<template>
    <div class="flex flex-col mb-4">
        <label :if="label" :for="props.inputName" class="mb-2">{{ label }}:</label>
        <textarea :name="props.inputName" :placeholder="props.placeholder" v-model="model" class="p-2 rounded-2xl border border-woodsmoke-900 dark:border-spring-wood-50 rounded bg-transparent shadow-inner h-52" :maxlength="props.length"></textarea>
    </div>
</template>