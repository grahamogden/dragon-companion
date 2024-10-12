<script setup lang="ts">
    import { PropType } from 'vue';
    import LinkButton from '../buttons/LinkButton.vue';
    import Button from '../buttons/Button.vue';
    import { ButtonSeverity } from '../buttons/button-severity';

    const props = defineProps({
        cancelDestination: { type: String, required: false, default: undefined },
        onCancel: { type: Function as PropType<((...args: any) => void) | undefined>, required: false, default: undefined },
        goBack: { type: Boolean, required: false, default: false }
    })

    const back = () => {
        window.history.back();
    }
</script>
<template>
    <div class="flex flex-col md:flex-row justify-center items-center gap-x-10 gap-y-6 w-full mt-10">
        <div class="md:order-last w-full md:w-auto text-center">
            <Button type="submit" :severity="ButtonSeverity.success" is-min-width>Save</Button>
        </div>
        <div v-if="onCancel || cancelDestination || goBack" class="w-full md:w-auto text-center">
            <Button v-if="onCancel" type="button" @button:on-click="onCancel"
                :severity="ButtonSeverity.primary">Cancel</Button>
            <LinkButton v-else-if="cancelDestination" :href="cancelDestination">Cancel</LinkButton>
            <Button v-else type="button" @button:on-click="back" :severity="ButtonSeverity.primary">Cancel</Button>
        </div>
    </div>
</template>