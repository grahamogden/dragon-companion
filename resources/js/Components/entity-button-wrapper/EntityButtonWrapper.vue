<script setup lang="ts">
    import LinkButton from '../buttons/LinkButton.vue';
    import PrimaryButton from '../buttons/PrimaryButton.vue'
    import SecondaryButton from '../buttons/SecondaryButton.vue';

    defineProps<{
        cancelDestination?: string,
        onCancel?: Function,
    }>()

    const back = () => {
        window.history.back();
    }
</script>
<template>
    <div class="flex flex-col md:flex-row justify-center items-center gap-x-10 gap-y-6 w-full mt-10">
        <div class="md:order-last w-full md:w-auto text-center">
            <PrimaryButton>Save</PrimaryButton>
        </div>
        <div class="w-full md:w-auto text-center">
            <SecondaryButton v-if="onCancel" :func="onCancel ?? back" :args="[]">Cancel</SecondaryButton>
            <LinkButton v-else-if="cancelDestination" :href="cancelDestination" :width-full="true">Cancel</LinkButton>
        </div>
    </div>
</template>