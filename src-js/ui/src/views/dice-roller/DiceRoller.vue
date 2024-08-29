<script setup lang="ts">
    import { ref, reactive, watch } from 'vue';
    import PageHeader from '../../components/page-header/PageHeader.vue';
    import DiceItem from './DiceItem.vue';
    import SecondaryButton from '../../components/buttons/SecondaryButton.vue';
    import DiceCreator from './DiceCreator.vue';
    import SmallHorizontalRule from '../../components/horizontal-rule/SmallHorizontalRule.vue';

    type DiceCountInterface = { count: number }
    type DiceCountsInterface = Record<number, DiceCountInterface>

    const diceCounts = reactive<DiceCountsInterface>({
        4: { count: 0, },
        6: { count: 0, },
        8: { count: 0, },
        10: { count: 0, },
        12: { count: 0, },
        20: { count: 0, },
    })
    const totalDice = ref(0)

    type DiceChildrenInterface = { rollDice: Function };

    const diceItems = reactive<Record<string, DiceChildrenInterface>>({})

    function rollAll() {
        const keys = Object.keys(diceItems) as Array<keyof {}>
        keys.forEach((key) => {
            if (diceItems[key]?.rollDice) {
                diceItems[key]?.rollDice()
            }
        })
    }

    function reset() {
        const keys = Object.keys(diceCounts).map(Number) as Array<keyof DiceCountsInterface>
        keys.forEach((key) => {
            diceCounts[key].count = 0
        })
    }

    watch(diceCounts, (newCounts) => {
        const keys = Object.keys(newCounts).map(Number) as Array<keyof DiceCountsInterface>
        let total = 0
        keys.forEach((key) => {
            total += newCounts[key].count
        })
        totalDice.value = total
    })
</script>
<template>
    <PageHeader>Dice Roller</PageHeader>
    <div class="mb-default">
        <p>Click or type in the number of dice you want of each kind and then roll them.</p>
        <p>You can roll a die individually by clicking on it or roll all of them with the button at the bottom of the
            page!</p>
    </div>
    <div class="mb-12">
        <div v-for="(diceCount, limit) in diceCounts" class="mb-6">
            <div class="mb-default">
                <DiceCreator v-model:dice-count="diceCount.count" :limit="parseInt('' + limit)"></DiceCreator>
            </div>
            <div v-if="diceCount.count" class="grid grid-cols-6 md:grid-cols-12 gap-default mb-default">
                <div v-for="count in diceCount.count">
                    <DiceItem :diceName="'d' + limit" :limit="parseInt('' + limit)"
                        :ref="(el) => { diceItems['d' + limit + '-' + count] = el as unknown as DiceChildrenInterface }">
                    </DiceItem>
                </div>
            </div>
            <SmallHorizontalRule></SmallHorizontalRule>
        </div>
    </div>
    <div v-if="totalDice > 0" class="flex flex-col md:flex-row gap-12 justify-center">
        <SecondaryButton :func="rollAll" :args="[]" class="md:order-2">Roll all</SecondaryButton>
        <SecondaryButton :func="reset" :args="[]" :is-destructive="true" class="md:order-1">Reset</SecondaryButton>
    </div>
</template>