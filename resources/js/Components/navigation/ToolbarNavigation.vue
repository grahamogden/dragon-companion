<script setup lang="ts">
    import { ref, watch } from 'vue'
    import { useCampaignStore, useConfigurationStore } from '../../stores/index'
    import ToolbarNavLink from '../NavLink/ToolbarNavLink.vue'
    import { vOnClickOutside } from '@vueuse/components'
    import { Link, usePage } from '@inertiajs/vue3';

    const campaignStore = useCampaignStore()
    const configStore = useConfigurationStore()
    const isNavMenuOpen = ref(false)
    const showDashboardLinks = ref(usePage().props.auth.user && campaignStore.isCampaignSelected)

    function toggleNavMenu(open?: boolean) {
        isNavMenuOpen.value = open ?? !isNavMenuOpen.value

        configStore.setOverlayActive(isNavMenuOpen.value)
    }

    function updateShowDashboardLinks() {
        showDashboardLinks.value = usePage().props.auth.user && campaignStore.isCampaignSelected
    }

    watch(() => usePage().props.auth.user, () => {
        updateShowDashboardLinks()
    })
    watch(() => campaignStore.isCampaignSelected, () => {
        updateShowDashboardLinks()
    })
</script>

<template>
    <div v-on-click-outside="() => isNavMenuOpen && toggleNavMenu(false)"
        class="fixed md:hidden bottom-0 w-full max-h-screen flex flex-col bg-timberwolf-50/85 dark:bg-woodsmoke-950/85 text-woodsmoke-950 dark:text-timberwolf-50 backdrop-blur shadow-md shadow-toolbar rounded-t-3xl transition-colors duration-theme-change overflow-hidden z-10">
        <Transition name="toolbar-navigation-slide">
            <div v-if="isNavMenuOpen"
                class="grid grid-cols-1 w-full w-full z-10 mx-auto border-b border-woodsmoke-300 text-center overflow-scroll">
                <nav class="toolbar-menu flex flex-col">
                    <ToolbarNavLink @click="toggleNavMenu(false)" :href="route('creator.campaigns.index')">
                        <font-awesome-icon :icon="['fas', 'book']" fixed-width
                            class="mr-2"></font-awesome-icon>Campaigns
                    </ToolbarNavLink>
                    <div class="flex flex-col">
                        <div class="px-4 py-2 bg-woodsmoke-300/50 dark:bg-woodsmoke-700/50 duration-theme-change">{{
                            campaignStore.campaignName }}</div>
                        <div v-if="showDashboardLinks"
                            class="campaign-image bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end">
                        </div>
                    </div>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.selectedCampaignId })">
                        <font-awesome-icon :icon="['fas', 'timeline']" fixed-width
                            class="mr-2"></font-awesome-icon>Timelines
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'user']" fixed-width
                            class="mr-2"></font-awesome-icon>Characters
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('dice-roller')">
                        <font-awesome-icon :icon="['fas', 'dice-d20']" fixed-width class="mr-2"></font-awesome-icon>Dice
                        Roller
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'person']" fixed-width
                            class="mr-2"></font-awesome-icon>Species
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'shield']" fixed-width class="mr-2"></font-awesome-icon>Items
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'dragon']" fixed-width
                            class="mr-2"></font-awesome-icon>Monsters
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'person-circle-plus']" fixed-width
                            class="mr-2"></font-awesome-icon>Permissions
                    </ToolbarNavLink>
                </nav>
            </div>
        </Transition>

        <nav class="toolbar grid grid-cols-4">
            <Link v-if="usePage().props.auth.user && !campaignStore.isCampaignSelected" class="navigation-toolbar-link"
                :href="route('creator.campaigns.index')" @click="toggleNavMenu(false)">
            <font-awesome-icon :icon="['fas', 'book']" fixed-width
                class="text-xl"></font-awesome-icon><span>Campaigns</span>
            </Link>

            <div v-if="usePage().props.auth.user && !campaignStore.isCampaignSelected"
                class="col-span-2 navigation-toolbar-link">Please select a
                campaign to start
                crafting!</div>

            <Link v-if="showDashboardLinks" class="navigation-toolbar-link"
                :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })"
                @click="toggleNavMenu(false)">
            <font-awesome-icon :icon="['fas', 'timeline']" fixed-width class="text-xl"></font-awesome-icon>Timelines
            </Link>

            <Link v-if="showDashboardLinks" class="navigation-toolbar-link"
                :href="route('creator.campaigns.index', { externalCampaignId: campaignStore.campaignId })"
                @click="toggleNavMenu(false)">
            <font-awesome-icon :icon="['fas', 'user']" fixed-width
                class="text-xl"></font-awesome-icon><span>Characters</span>
            </Link>

            <Link class="navigation-toolbar-link" :href="route('dice-roller')" @click="toggleNavMenu(false)">
            <font-awesome-icon :icon="['fas', 'dice-d20']" fixed-width class="text-xl"></font-awesome-icon><span>Dice
                Roller</span>
            </Link>

            <Link v-if="!usePage().props.auth.user" class="navigation-toolbar-link" :href="route('login')">
            <font-awesome-icon :icon="['fas', 'right-to-bracket']" fixed-width
                class="text-xl"></font-awesome-icon><span>Log
                In</span>
            </Link>

            <Link v-if="!usePage().props.auth.user" class="navigation-toolbar-link" :href="route('register')">
            <font-awesome-icon :icon="['fas', 'star']" fixed-width
                class="text-xl"></font-awesome-icon><span>Register</span>
            </Link>

            <div v-if="!usePage().props.auth.user"></div>

            <button v-if="showDashboardLinks" type="button"
                class="flex flex-col items-center gap-1 text-woodsmoke-950 dark:text-white-lilac-50 py-3 underline text-center transition-colors duration-theme-change"
                @click="toggleNavMenu()"><font-awesome-icon :icon="['fas', 'bars']" fixed-width
                    class="text-xl"></font-awesome-icon><span>Menu</span></button>
        </nav>
    </div>
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
    .toolbar-navigation-slide-enter-active .campaign-image,
    .toolbar-navigation-slide-leave-active .campaign-image {
        transition-property: padding, line-height, font-size, height;
        transition-duration: 0.15s;
        transition-timing-function: ease-in-out;
        transition-delay: 0ms;
    }

    /* .toolbar-navigation-slide-enter-to,
    .toolbar-navigation-slide-leave-from,
    .toolbar-navigation-slide-enter-to div,
    .toolbar-navigation-slide-leave-from div {
        line-height: normal;
        font-size: normal;
    } */
</style>