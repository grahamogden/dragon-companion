<script setup lang="ts">
    import { useUserAuthStore, useCampaignStore } from '../../stores'
    import CampaignPicker from '../campaign-picker/CampaignPicker.vue'
    import NavLink from '../nav-link/NavLink.vue'

    const userAuthStore = useUserAuthStore()
    const campaignStore = useCampaignStore()
</script>

<template>
    <campaign-picker></campaign-picker>
    <div class="flex flex-col w-full">
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
</template>