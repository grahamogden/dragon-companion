<script setup lang="ts">
const props = defineProps<{
    text: string
}>()
</script>
<template>
    <!-- <div :class="'w-full mb-4 inline-block md:w-auto ' + orderClass">  mb-4 md:mb-0-->
        <button
            class="py-2 px-4 rounded-lg bg-biscay-800 text-spring-wood-50 font-bold min-w-48 relative text-center no-underline w-full md:w-auto md:min-w-48"
            type="submit">{{ props.text }}</button>
    <!-- </div> -->
</template>