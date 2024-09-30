<script setup lang="ts">
    import PrimaryButton from '../buttons/PrimaryButton.vue'
    // import LinkButton from '../buttons/LinkButton.vue';
    import SecondaryButton from '../buttons/SecondaryButton.vue';

    defineProps<{
        cancelDestination?: string | undefined,
        onCancel?: Function | undefined,
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
            <SecondaryButton :func="onCancel ?? back" :args="[]">Cancel</SecondaryButton>
            <!-- <LinkButton :href="cancelDestination" :width-full="true">Cancel</LinkButton> -->
        </div>
    </div>
</template>