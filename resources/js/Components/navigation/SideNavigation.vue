<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { useCampaignStore } from '../../stores'
    import NavLink from '../NavLink/NavLink.vue'

    const campaignStore = useCampaignStore()
</script>

<template>
    <div class="hidden md:flex flex-col w-full md:max-w-64 text-left rounded-tr-none rounded-l-3xl overflow-hidden">
        <div class="campaign-picker relative">
            <div class="bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end"></div>
            <div class="table absolute top-0 left-0 w-full h-full">
                <Link
                    class="table-cell align-middle text-white-lilac-50 bg-shark-950/75 backdrop-blur-sm hover:no-underline focus:no-underline text-center transition-opacity duration-150"
                    :class="{ 'opacity-0': campaignStore.isCampaignSelected }" :href="route('creator.campaigns.index')">
                Go To
                Your Campaigns</Link>
            </div>
            <div v-if="campaignStore.isCampaignSelected"
                class="px-4 py-2 bg-timberwolf-50/80 dark:bg-woodsmoke-950/80 backdrop-blur-sm duration-theme-change">{{
                    campaignStore.campaignName }}</div>
        </div>
        <div class="flex flex-col w-full pb-4 bg-shark-950/70 backdrop-blur-lg grow">
            <nav v-if="$page.props.auth.user && campaignStore.isCampaignSelected" class="side-nav flex flex-col">
                <NavLink :href="route('creator.campaigns.timelines.index', { campaign: campaignStore.campaignId })">
                    <font-awesome-icon :icon="['fas', 'timeline']" fixed-width class="mr-2" />Timelines
                </NavLink>
                <NavLink :href="route('creator.campaigns.index', { campaign: campaignStore.campaignId })">
                    <font-awesome-icon :icon="['fas', 'users']" fixed-width class="mr-2" />Characters
                </NavLink>
                <NavLink :href="route('dice-roller')">
                    <font-awesome-icon :icon="['fas', 'dice-d20']" fixed-width class="mr-2" />Dice Roller
                </NavLink>
                <NavLink :href="route('creator.campaigns.index', { campaign: campaignStore.campaignId })">
                    <font-awesome-icon :icon="['fas', 'person']" fixed-width class="mr-2" />Species
                </NavLink>
                <NavLink :href="route('creator.campaigns.items.index', { campaign: campaignStore.campaignId })">
                    <font-awesome-icon :icon="['fas', 'shield']" fixed-width class="mr-2" />Items
                </NavLink>
                <NavLink :href="route('creator.campaigns.index', { campaign: campaignStore.campaignId })">
                    <font-awesome-icon :icon="['fas', 'dragon']" fixed-width class="mr-2" />Monsters
                </NavLink>
                <NavLink :href="route('creator.campaigns.index', { campaign: campaignStore.campaignId })">
                    <font-awesome-icon :icon="['fas', 'person-circle-plus']" fixed-width class="mr-2" />Permissions
                </NavLink>
            </nav>
            <div v-if="!($page.props.auth.user && campaignStore.isCampaignSelected)"
                class="w-full max-w-page text-timberwolf-100 py-3 px-4 mx-auto">Please select a campaign to start
                crafting!
            </div>
        </div>
    </div>
</template>