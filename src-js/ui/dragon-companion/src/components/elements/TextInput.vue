<script setup lang="ts">
const emit = defineEmits(['updateValue'])
const props = defineProps<{
    // inputValue: string | number
    placeholder?: string
    inputName: string
    label?: string | number
}>()

const model = defineModel()
// function update(value: string) {
//     model.value = value
// }
</script>

<template>
    <div>
        <label :for="props.inputName">{{ label }}:</label>
        <input type="text" :name="props.inputName" :placeholder="props.placeholder" v-model="model" />
        <!-- <input type="text" :name="props.inputName" :placeholder="props.placeholder" :value="props.inputValue" @input="emit('updateValue', props.inputName, $event.target?.value)" /> -->
    </div>
</template>