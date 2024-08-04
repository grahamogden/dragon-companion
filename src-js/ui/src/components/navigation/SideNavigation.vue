<script setup lang="ts">
    import { useUserAuthStore, useCampaignStore } from '../../stores'
    import CampaignPicker from '../campaign-picker/CampaignPicker.vue'
    import NavLink from '../nav-link/NavLink.vue'

    const userAuthStore = useUserAuthStore()
    const campaignStore = useCampaignStore()
</script>

<template>
    <div class="hidden md:flex flex-col w-full md:max-w-64 text-left rounded-tr-none rounded-l-3xl overflow-hidden">
        <div class="campaign-picker relative">
            <div v-if="campaignStore.isCampaignSelected"
                class="px-4 py-2 bg-timberwolf-50/80 dark:bg-woodsmoke-950/80 backdrop-blur-sm duration-theme-change">{{
                campaignStore.campaignName }}</div>
            <div class="bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end"></div>
            <div class="table absolute top-0 left-0 w-full h-full">
                <router-link
                    class="table-cell align-middle text-white-lilac-50 bg-shark-950/75 backdrop-blur-sm hover:no-underline focus:no-underline text-center transition-opacity duration-150"
                    :class="{ 'opacity-0': campaignStore.isCampaignSelected }" :to="{ name: 'campaigns.list' }">Go To
                    Your Campaigns</router-link>
            </div>
        </div>
        <div class="flex flex-col w-full bg-shark-950/70 backdrop-blur-lg grow">
            <nav v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected" class="side-nav flex flex-col">
                <nav-link
                    :destination="{ name: 'timelines.list', params: { externalCampaignId: campaignStore.campaignId } }">Timelines</nav-link>
                <nav-link
                    :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Characters</nav-link>
                <nav-link
                    :destination="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }">Combat
                    Encounters</nav-link>
                <nav-link
                    :destination="{ name: 'species.list', params: { externalCampaignId: campaignStore.campaignId } }">Species</nav-link>
                <nav-link
                    :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Objects</nav-link>
                <nav-link
                    :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Monsters</nav-link>
                <nav-link
                    :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Permissions</nav-link>
            </nav>
            <div v-if="!(userAuthStore.isLoggedIn && campaignStore.isCampaignSelected)"
                class="w-full max-w-page text-timberwolf-100 py-3 px-4 mx-auto">Please select a campaign to start
                crafting!
            </div>
        </div>
    </div>
</template>