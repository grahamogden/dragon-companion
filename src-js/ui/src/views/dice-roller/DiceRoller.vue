<script setup lang="ts">
    import { ref } from 'vue';
    import BaseInput from '../../components/fields/BaseInput.vue';
    import PageHeader from '../../components/page-header/PageHeader.vue';
    import DiceItem from './DiceItem.vue';
    import SecondaryButton from '../../components/buttons/SecondaryButton.vue';
    import ContentGroup from '../../components/elements/ContentGroup.vue';

    const d4Count = ref(0)
    const d6Count = ref(0)
    const d8Count = ref(0)
    const d10Count = ref(0)
    const d12Count = ref(0)
    const d20Count = ref(0)

    type diceChildrenType = Element | ComponentPublicInstance | null;

    const diceChildren = ref<Record<string, diceChildrenType>>({})

    function rollAll() {
        console.debug(diceChildren.value)
        const keys = Object.keys(diceChildren.value) as Array<keyof string>
        keys.forEach((key) => {
            if (diceChildren.value[key]?.rollDice) {
                diceChildren.value[key]?.rollDice()
            }
        })
    }
</script>
<template>
    <PageHeader>Dice Roller</PageHeader>
    <div class="grid grid-cols-6 md:grid-cols-12 gap-default mb-default">
        <BaseInput type="number" v-model:model="d4Count" input-name="d4Count" label="d4 count"></BaseInput>
        <BaseInput type="number" v-model:model="d6Count" input-name="d6Count" label="d6 count"></BaseInput>
        <BaseInput type="number" v-model:model="d8Count" input-name="d8Count" label="d8 count"></BaseInput>
        <BaseInput type="number" v-model:model="d10Count" input-name="d10Count" label="d10 count"></BaseInput>
        <BaseInput type="number" v-model:model="d12Count" input-name="d12Count" label="d12 count"></BaseInput>
        <BaseInput type="number" v-model:model="d20Count" input-name="d20Count" label="d20 count"></BaseInput>
    </div>
    <div class="grid grid-cols-1 mb-default">
        <div>You can roll a die individually by clicking on it or roll all of them with the button at the bottom of the
            page!</div>
    </div>
    <div class="grid grid-cols-1 gap-default mb-12">
        <ContentGroup v-if="d4Count">
            <template #heading>{{ d4Count }}d4</template>
            <template #content>
                <div class="grid grid-cols-6 md:grid-cols-12 gap-default">
                    <div v-for="(d4, index) in d4Count">
                        <DiceItem diceName="d4" :limit=4 :ref="(el) => diceChildren['d4' + index] = el"></DiceItem>
                    </div>
                </div>
            </template>
        </ContentGroup>
        <ContentGroup v-if="d6Count">
            <template #heading>{{ d6Count }}d6</template>
            <template #content>
                <div class="grid grid-cols-6 md:grid-cols-12 gap-default">
                    <div v-for="(d6, index) in d6Count">
                        <DiceItem diceName="d6" :limit=6 :ref="(el) => diceChildren['d6' + index] = el"></DiceItem>
                    </div>
                </div>
            </template>
        </ContentGroup>
        <ContentGroup v-if="d8Count">
            <template #heading>{{ d8Count }}d8</template>
            <template #content>
                <div class="grid grid-cols-6 md:grid-cols-12 gap-default">
                    <div v-for="(d8, index) in d8Count">
                        <DiceItem diceName="d8" :limit=8 :ref="(el) => diceChildren['d8' + index] = el"></DiceItem>
                    </div>
                </div>
            </template>
        </ContentGroup>
        <ContentGroup v-if="d10Count">
            <template #heading>d{{ d10Count }}10</template>
            <template #content>
                <div class="grid grid-cols-6 md:grid-cols-12 gap-default">
                    <div v-for="(d10, index) in d10Count">
                        <DiceItem diceName="d10" :limit=10 :ref="(el) => diceChildren['d10' + index] = el"></DiceItem>
                    </div>
                </div>
            </template>
        </ContentGroup>
        <ContentGroup v-if="d12Count">
            <template #heading>d{{ d12Count }}12</template>
            <template #content>
                <div class="grid grid-cols-6 md:grid-cols-12 gap-default">
                    <div v-for="(d12, index) in d12Count">
                        <DiceItem diceName="d12" :limit=12 :ref="(el) => diceChildren['d12' + index] = el"></DiceItem>
                    </div>
                </div>
            </template>
        </ContentGroup>
        <ContentGroup v-if="d20Count">
            <template #heading>d{{ d20Count }}20</template>
            <template #content>
                <div class="grid grid-cols-6 md:grid-cols-12 gap-default">
                    <div v-for="(d20, index) in d20Count">
                        <DiceItem diceName="d20" :limit=20 :ref="(el) => diceChildren['d20' + index] = el"></DiceItem>
                    </div>
                </div>
            </template>
        </ContentGroup>
    </div>
    <div v-if="d4Count + d6Count + d8Count + d10Count + d12Count + d20Count > 0" class="">
        <SecondaryButton @click="rollAll()">Roll all</SecondaryButton>
    </div>
</template>