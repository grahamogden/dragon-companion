<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';
import PrimaryButton from '../elements/PrimaryButton.vue'
import LinkButton from '../elements/LinkButton.vue'


const props = defineProps<{
    cancelDestination: RouteLocationRaw
}>()
</script>
<template>
    <div class="mt-10 flex flex-col md:flex-row justify-center gap-x-10 gap-y-6">
        <div class="md:order-last">
            <PrimaryButton text="Save" />
        </div>
        <div class="w-full md:w-auto text-center">
            <!-- <LinkButton text="Cancel" :destination="props.cancelDestination" /> -->
            <router-link :to="props.cancelDestination" class="my-2">Cancel</router-link>
        </div>
        <!-- <button class="primary-button my-2" type="submit">Save</button> -->
        <!-- <router-link :to="{ name: 'campaigns.list' }" class="secondary-button my-4" >Cancel</router-link> -->
    </div>
</template>