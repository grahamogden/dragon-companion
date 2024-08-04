<script setup lang="ts">
    import { ref } from 'vue'
    import { RouterLink } from 'vue-router'
    import { useCampaignStore, useUserAuthStore } from '../../stores'
    import ToolbarNavLink from '../nav-link/ToolbarNavLink.vue';

    const campaignStore = useCampaignStore()
    const userAuthStore = useUserAuthStore()
    const isNavMenuOpen = ref(false)

    function toggleNavMenu(open: boolean | undefined = undefined) {
        if (open === undefined) {
            isNavMenuOpen.value = !isNavMenuOpen.value
        } else {
            isNavMenuOpen.value = open
        }
    }
</script>

<template>
    <div
        class="fixed md:hidden bottom-0 w-full max-h-screen flex flex-col bg-timberwolf-50/85 dark:bg-woodsmoke-950/85 text-woodsmoke-950 dark:text-timberwolf-50 backdrop-blur shadow-md shadow-toolbar rounded-t-3xl overflow-hidden z-10">
        <Transition name="toolbar-navigation-slide">
            <div v-show="isNavMenuOpen" class="grid grid-cols-1 w-full w-full z-10 mx-auto text-center overflow-scroll">
                <ToolbarNavLink @click="toggleNavMenu(false)" :destination="{ name: 'campaigns.list' }">
                    Campaigns</ToolbarNavLink>
                <div v-if="campaignStore.isCampaignSelected"
                    class="px-4 py-2 bg-woodsmoke-300/50 dark:bg-woodsmoke-700/50 duration-theme-change">
                    {{ campaignStore.campaignName }}
                </div>
                <div class="campaign-image bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end">
                </div>
                <!-- <div class="table absolute top-0 left-0 w-full h-full">
                        <router-link
                            class="table-cell align-middle text-white-lilac-50 bg-shark-950/75 backdrop-blur-sm hover:no-underline focus:no-underline text-center transition-opacity duration-150"
                            :class="{ 'opacity-0': campaignStore.isCampaignSelected }"
                            :to="{ name: 'campaigns.list' }">Go
                            To
                            Your Campaigns</router-link>
                    </div> -->
                <nav v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected" class="side-nav flex flex-col">
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'timelines.list', params: { externalCampaignId: campaignStore.campaignId } }">
                        Timelines</ToolbarNavLink>
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">
                        Characters</ToolbarNavLink>
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }">
                        Combat
                        Encounters</ToolbarNavLink>
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'species.list', params: { externalCampaignId: campaignStore.campaignId } }">
                        Species</ToolbarNavLink>
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">
                        Objects</ToolbarNavLink>
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">
                        Monsters</ToolbarNavLink>
                    <ToolbarNavLink @click="toggleNavMenu(false)"
                        :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">
                        Permissions</ToolbarNavLink>
                </nav>
                <div v-if="!(userAuthStore.isLoggedIn && campaignStore.isCampaignSelected)"
                    class="w-full max-w-page text-timberwolf-100 py-3 px-4 mx-auto">Please select a campaign to
                    start
                    crafting!
                </div>
            </div>
        </Transition>
        <nav class="toolbar grid grid-cols-4 gap-4" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected">
            <router-link class="text-woodsmoke-950 dark:text-white-lilac-50 py-3 text-center"
                :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"><img
                    src="@/assets/images/dice-icon.svg" class="w-12 h-12 block rounded inline-block" /><span
                    class="inline-block w-full truncate text-ellipsis overflow-hidden">Characters</span></router-link>
            <button type="button" class="text-woodsmoke-950 dark:text-white-lilac-50 py-3 underline text-center"
                @click="toggleNavMenu()"><img src="@/assets/images/dice-icon.svg"
                    class="w-12 h-12 block rounded inline-block" /><span
                    class="inline-block w-full truncate text-ellipsis overflow-hidden">More</span></button>
        </nav>
    </div>
    <div v-if="isNavMenuOpen" @click="toggleNavMenu(false)"
        class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 md:hidden"></div>
</template>

<style>

    .toolbar-navigation-slide-enter-from,
    .toolbar-navigation-slide-leave-to,
    .toolbar-navigation-slide-enter-from div,
    .toolbar-navigation-slide-leave-to div {
        line-height: 0;
        font-size: 0;
    }

    .toolbar-navigation-slide-enter-from a,
    .toolbar-navigation-slide-leave-to a,
    .toolbar-navigation-slide-enter-from div,
    .toolbar-navigation-slide-leave-to div {
        padding: 0;
    }

    .toolbar-navigation-slide-enter-from .campaign-image,
    .toolbar-navigation-slide-leave-to .campaign-image {
        height: 0;
    }

    .toolbar-navigation-slide-enter-active,
    .toolbar-navigation-slide-leave-active,
    .toolbar-navigation-slide-enter-active a,
    .toolbar-navigation-slide-leave-active a,
    .toolbar-navigation-slide-enter-active div,
    .toolbar-navigation-slide-leave-active div,
    .toolbar-navigation-slide-enter-active .campaign-picker,
    .toolbar-navigation-slide-leave-active .campaign-picker {
        transition-property: padding, line-height, font-size, height;
        transition-duration: 0.3s;
        transition-timing-function: ease;
        transition-delay: 0ms;
    }

    .toolbar-navigation-slide-enter-to,
    .toolbar-navigation-slide-leave-from,
    .toolbar-navigation-slide-enter-to div,
    .toolbar-navigation-slide-leave-from div {
        line-height: normal;
        font-size: normal;
    }

    .scale-enter-from,
    .scale-leave-to {
        /* bottom: 0rem; */
        transform: scale(1, 0);
    }

    .scale-enter-active,
    .scale-leave-active {
        transition-property: transform, bottom;
        transition-duration: 0.3s;
        transition-timing-function: ease;
        transition-delay: 0ms;
        transform-origin: center bottom;
    }

    .scale-enter-to,
    .scale-leave-from {
        transform: scale(1, 1);
    }
</style>