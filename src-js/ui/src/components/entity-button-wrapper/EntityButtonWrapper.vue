<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';
    import PrimaryButton from '../buttons/PrimaryButton.vue'
    import SecondaryButton from '../buttons/SecondaryButton.vue'


    const props = defineProps<{
        cancelDestination: RouteLocationRaw
    }>()
</script>
<template>
    <div class="flex flex-col md:flex-row justify-center items-center gap-x-10 gap-y-6 w-full mt-10">
        <div class="md:order-last w-full md:w-auto text-center">
            <PrimaryButton>Save</PrimaryButton>
        </div>
        <div class="w-full md:w-auto text-center">
            <SecondaryButton :destination="props.cancelDestination">Cancel</SecondaryButton>
        </div>
    </div>
</template>