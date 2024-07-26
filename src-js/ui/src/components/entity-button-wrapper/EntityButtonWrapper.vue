<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';
    import PrimaryButton from '../buttons/PrimaryButton.vue'
    import SecondaryButton from '../buttons/SecondaryButton.vue'
    import LinkButton from '../buttons/LinkButton.vue';


    const props = defineProps<{
        cancelDestination: RouteLocationRaw
    }>()
</script>
<template>
    <div class="flex flex-col md:flex-row justify-center items-center gap-x-10 gap-y-6 w-full mt-10">
        <div class="md:order-last w-full md:w-auto text-center">
            <primary-button>Save</primary-button>
        </div>
        <div class="w-full md:w-auto text-center">
            <link-button :destination="props.cancelDestination">Cancel</link-button>
            <secondary-button :destination="props.cancelDestination">Cancel</secondary-button>
            <!-- <router-link :to="props.cancelDestination" class="my-2 lg:my-0">Cancel</router-link> -->
        </div>
        <!-- <button class="primary-button my-2" type="submit">Save</button> -->
        <!-- <router-link :to="{ name: 'campaigns.list' }" class="secondary-button my-4" >Cancel</router-link> -->
    </div>
</template>