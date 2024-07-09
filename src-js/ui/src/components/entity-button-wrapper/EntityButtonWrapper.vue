<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';
import PrimaryButton from '../elements/buttons/PrimaryButton.vue'
import SecondaryButton from '../elements/buttons/SecondaryButton.vue'


const props = defineProps<{
    cancelDestination: RouteLocationRaw
}>()
</script>
<template>
    <div class="mt-10 flex flex-col md:flex-row justify-center items-center gap-x-10 gap-y-6">
        <div class="md:order-last w-full md:w-auto text-center">
            <primary-button>Save</primary-button>
        </div>
        <div class="w-full md:w-auto text-center">
            <secondary-button :destination="props.cancelDestination">Cancel</secondary-button>
            <!-- <router-link :to="props.cancelDestination" class="my-2 lg:my-0">Cancel</router-link> -->
        </div>
        <!-- <button class="primary-button my-2" type="submit">Save</button> -->
        <!-- <router-link :to="{ name: 'campaigns.list' }" class="secondary-button my-4" >Cancel</router-link> -->
    </div>
</template>