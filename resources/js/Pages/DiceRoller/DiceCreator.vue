<script setup lang="ts">
    const model = defineModel<number>('diceCount', {
        required: true
    })

    defineProps<{
        limit: number
    }>()
</script>
<template>
    <div class="grid grid-col-1 gap-0 items-center justify-center text-center text-xl">
        <button @click="++model" class="no-zoom w-full p-1 bg-fern-500 rounded-t-lg"
            :aria-label="'Increase number of d ' + limit + ' dice'">+</button>
        <div class="flex items-center bg-timberwolf-50 dark:bg-woodsmoke-800 p-1 duration-theme-change">
            <input type="number" v-model="model" :input-name="'d' + limit + '-counter'"
                class="max-w-16 p-0 pr-1 bg-timberwolf-50 dark:bg-woodsmoke-800  border-none text-right duration-theme-change"></input>d{{
                    limit }}
        </div>
        <button @click="--model" class="no-zoom w-full p-1 bg-alizarin-crimson-500 rounded-b-lg"
            :aria-label="'Decrease number of d ' + limit + ' dice'">-</button>
    </div>
</template>