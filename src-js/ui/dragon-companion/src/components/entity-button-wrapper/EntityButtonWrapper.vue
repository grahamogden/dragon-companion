<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';
import PrimaryButton from '../elements/PrimaryButton.vue'
import LinkButton from '../elements/LinkButton.vue'


const props = defineProps<{
    cancelDestination: RouteLocationRaw
}>()
</script>
<template>
    <div class="mt-10">
        <PrimaryButton text="Save" />
        <LinkButton text="Cancel" :destination="props.cancelDestination" />
        <!-- <button class="primary-button my-2" type="submit">Save</button> -->
        <!-- <router-link :to="{ name: 'campaigns.list' }" class="secondary-button my-4" >Cancel</router-link> -->
    </div>
</template>