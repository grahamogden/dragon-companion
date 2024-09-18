<script setup lang="ts">
    const props = defineProps<{
        text: string,
        isSelected?: boolean,
    }>()
</script>

<template>
    <div
        class="w-full rounded-xl shadow-sm shadow-shark-500 dark:shadow-stone-950 transition-colors-and-shadow duration-theme-change">
        <div class="relative rounded-t-xl overflow-hidden border-0 border-b-0"
            :class="props.isSelected ? 'border-saffron-mango-300' : 'border-timberwolf-200 dark:border-woodsmoke-800'">
            <img src="../../assets/images/background/light/full.svg">
            <!-- <div class="absolute top-0 left-0 border-[2rem] border-transparent border-l-saffron-mango-300 border-t-saffron-mango-300"
                :class="props.isSelected ? 'block' : 'hidden'">
            </div> -->
            <div class="absolute flex justify-center items-center top-0 left-0 w-full h-full bg-timberwolf-50/80 dark:bg-woodsmoke-900/80 border-8 md:border-[1rem] border-saffron-mango-300 transition-colors duration-theme-change"
                :class="props.isSelected ? 'block' : 'hidden'">Currently selected
            </div>
        </div>
        <div
            class="p-2 flex flex-row grow justify-between bg-timberwolf-50 dark:bg-woodsmoke-900 rounded-b-xl border-0 border-t-0 transition-colors duration-theme-change">
            <slot></slot>
        </div>
    </div>
</template>