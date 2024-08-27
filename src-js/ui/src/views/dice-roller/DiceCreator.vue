<script setup lang="ts">
    const model = defineModel<number>('diceCount', {
        required: true
    })

    const props = defineProps<{
        limit: number
    }>()
</script>
<template>
    <!-- <BaseInput type="number" v-model:model="diceCount" :input-name="'d' + limit + 'Count'"
    :label="'d' + limit + ' count'"></BaseInput> -->
    <div class="grid grid-rows-1 grid-flow-col gap-0 items-center justify-center text-center text-xl">
        <button @click="--model" class="no-zoom max-w-16 px-4 py-2 bg-alizarin-crimson-500 rounded-l-lg"
            :aria-label="'Decrease number of d ' + limit + ' dice'">-</button>
        <div class="bg-timberwolf-50 dark:bg-woodsmoke-800 pr-2 duration-theme-change">
            <input type="number" v-model="model" :input-name="'d' + limit + '-counter'"
                class="max-w-16 p-2 bg-timberwolf-50 dark:bg-woodsmoke-800 text-center duration-theme-change"></input>d{{
                    limit }}
        </div>
        <button @click="++model" class="no-zoom max-w-16 px-4 py-2 bg-fern-500 rounded-r-lg"
            :aria-label="'Increase number of d ' + limit + ' dice'">+</button>
    </div>
</template>