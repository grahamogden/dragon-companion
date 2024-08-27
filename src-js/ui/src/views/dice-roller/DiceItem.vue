<script setup lang="ts">
    import { ref } from 'vue';
    import DiceRoller from '../../services/dice-roller/DiceRollerService';

    const props = defineProps<{
        limit: number
        diceName: string
    }>()

    const dice = new DiceRoller(props.limit)
    const currentRoll = ref<number | undefined>();

    defineExpose({ rollDice })

    function rollDice() {
        let count = 0;
        const rolling = setInterval(() => {
            dice.roll()
            currentRoll.value = dice.currentRoll
            if (count >= 5) {
                clearInterval(rolling)
            } else {
                ++count
            }
        }, 80)
    }
</script>
<template>
    <button @click="rollDice()" type="button"
        class="relative w-full flex flex-col items-center p-2 bg-timberwolf-50 dark:bg-woodsmoke-800 border border-woodsmoke-300 dark:border-woodsmoke-600 rounded-xl duration-theme-change">
        <div class="text-2xl">{{ currentRoll ?? 'X' }}</div>
    </button>
</template>