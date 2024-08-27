<script setup lang="ts">
    import { ref, reactive, watch } from 'vue';
    import BaseInput from '../../components/fields/BaseInput.vue';
    import PageHeader from '../../components/page-header/PageHeader.vue';
    import DiceItem from './DiceItem.vue';
    import SecondaryButton from '../../components/buttons/SecondaryButton.vue';
    import ContentGroup from '../../components/elements/ContentGroup.vue';
    import DiceCreator from './DiceCreator.vue';
    import SmallHorizontalRule from '../../components/horizontal-rule/SmallHorizontalRule.vue';

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

    type DiceCountInterface = { count: number }
    type DiceCountsInterface = Record<number, DiceCountInterface>

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
        <div>You can roll a die individually by clicking on it or roll all of them with the button at the bottom of the
            page!</div>
    </div>
    <div class="mb-12">
        <div v-for="(diceCount, limit) in diceCounts" class="mb-6">
            <div class="mb-default">
                <DiceCreator v-model:dice-count="diceCount.count" :limit="limit"></DiceCreator>
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
    <div v-if="totalDice > 0" class="flex justify-center">
        <SecondaryButton :func="rollAll" :args="[]">Roll all</SecondaryButton>
    </div>
</template>