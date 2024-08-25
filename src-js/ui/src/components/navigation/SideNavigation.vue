<script setup lang="ts">
    import { useUserAuthStore, useCampaignStore } from '../../stores'
    import NavLink from '../nav-link/NavLink.vue'

    const userAuthStore = useUserAuthStore()
    const campaignStore = useCampaignStore()
</script>

<template>
    <div class="hidden md:flex flex-col w-full md:max-w-64 text-left rounded-tr-none rounded-l-3xl overflow-hidden">
        <div class="campaign-picker relative">
            <div class="bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end"></div>
            <div class="table absolute top-0 left-0 w-full h-full">
                <RouterLink
                    class="table-cell align-middle text-white-lilac-50 bg-shark-950/75 backdrop-blur-sm hover:no-underline focus:no-underline text-center transition-opacity duration-150"
                    :class="{ 'opacity-0': campaignStore.isCampaignSelected }" :to="{ name: 'campaigns.list' }">Go To
                    Your Campaigns</RouterLink>
            </div>
            <div v-if="campaignStore.isCampaignSelected"
                class="px-4 py-2 bg-timberwolf-50/80 dark:bg-woodsmoke-950/80 backdrop-blur-sm duration-theme-change">{{
                    campaignStore.campaignName }}</div>
        </div>
        <div class="flex flex-col w-full pb-4 bg-shark-950/70 backdrop-blur-lg grow">
            <nav v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected" class="side-nav flex flex-col">
                <NavLink
                    :destination="{ name: 'timelines.list', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'timeline']" fixed-width class="mr-2" />Timelines
                </NavLink>
                <NavLink
                    :destination="{ name: 'characters.list', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'users']" fixed-width class="mr-2" />Characters
                </NavLink>
                <NavLink
                    :destination="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'dice-d20']" fixed-width class="mr-2" />Combat Encounters
                </NavLink>
                <NavLink
                    :destination="{ name: 'species.list', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'person']" fixed-width class="mr-2" />Species
                </NavLink>
                <NavLink
                    :destination="{ name: 'items.list', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'shield']" fixed-width class="mr-2" />Items
                </NavLink>
                <NavLink
                    :destination="{ name: 'monsters.list', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'dragon']" fixed-width class="mr-2" />Monsters
                </NavLink>
                <NavLink
                    :destination="{ name: 'characters.list', params: { externalCampaignId: campaignStore.campaignId } }">
                    <font-awesome-icon :icon="['fas', 'person-circle-plus']" fixed-width class="mr-2" />Permissions
                </NavLink>
            </nav>
            <div v-if="!(userAuthStore.isLoggedIn && campaignStore.isCampaignSelected)"
                class="w-full max-w-page text-timberwolf-100 py-3 px-4 mx-auto">Please select a campaign to start
                crafting!
            </div>
        </div>
    </div>
</template>