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
    <div v-on-click-outside="() => isNavMenuOpen && toggleNavMenu(false)">
        <Transition name="toolbar-navigation-slide">
            <div v-if="isNavMenuOpen"
                class="fixed md:hidden bottom-0 w-full max-h-screen border bg-timberwolf-50/85 dark:bg-woodsmoke-950/85 text-woodsmoke-950 dark:text-timberwolf-50 backdrop-blur shadow-md shadow-toolbar rounded-t-3xl border-woodsmoke-300 overflow-hidden grid grid-cols-1 pb-20 z-10 mx-auto text-center overflow-scroll">
                <nav class="toolbar-menu grid grid-cols-2">
                    <ToolbarNavLink @click="toggleNavMenu(false)" :href="route('creator.campaigns.index')"
                        class="col-span-2" active-on-exact>
                        <font-awesome-icon :icon="['fas', 'book']" fixed-width
                            class="mr-2"></font-awesome-icon>Campaigns
                    </ToolbarNavLink>
                    <div class="flex flex-col col-span-2">
                        <div class="px-4 py-2 bg-woodsmoke-300/50 dark:bg-woodsmoke-700/50 duration-theme-change">{{
                            campaignStore.campaignName }}</div>
                        <div v-if="showDashboardLinks"
                            class="campaign-image bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end">
                        </div>
                    </div>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.timelines.index', { campaign: campaignStore.selectedCampaignId })">
                        <font-awesome-icon :icon="['fas', 'timeline']" fixed-width
                            class="mr-2"></font-awesome-icon>Timelines
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.characters.index', { campaign: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'user']" fixed-width
                            class="mr-2"></font-awesome-icon>Characters
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('dice-roller')">
                        <font-awesome-icon :icon="['fas', 'dice-d20']" fixed-width class="mr-2"></font-awesome-icon>Dice
                        Roller
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.species.index', { campaign: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'person']" fixed-width
                            class="mr-2"></font-awesome-icon>Species
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.items.index', { campaign: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'shield']" fixed-width class="mr-2"></font-awesome-icon>Items
                    </ToolbarNavLink>
                    <ToolbarNavLink v-if="showDashboardLinks" @click="toggleNavMenu(false)"
                        :href="route('creator.campaigns.monsters.index', { campaign: campaignStore.campaignId })">
                        <font-awesome-icon :icon="['fas', 'dragon']" fixed-width
                            class="mr-2"></font-awesome-icon>Monsters
                    </ToolbarNavLink>
                </nav>
            </div>
        </Transition>

        <div
            class="fixed md:hidden bottom-0 w-full flex flex-col border-t bg-timberwolf-50/85 dark:bg-woodsmoke-950/85 text-woodsmoke-950 dark:text-timberwolf-50 backdrop-blur shadow-md shadow-toolbar transition-colors duration-theme-change border-woodsmoke-300 z-10">

            <nav class="toolbar grid grid-cols-4">
                <Link v-if="usePage().props.auth.user && !campaignStore.isCampaignSelected"
                    class="navigation-toolbar-link no-zoom" :href="route('creator.campaigns.index')"
                    @click="toggleNavMenu(false)">
                <font-awesome-icon :icon="['fas', 'book']" fixed-width
                    class="text-xl"></font-awesome-icon><span>Campaigns</span>
                </Link>

                <div v-if="usePage().props.auth.user && !campaignStore.isCampaignSelected"
                    class="col-span-2 navigation-toolbar-link">Please select a
                    campaign to start
                    crafting!</div>

                <Link v-if="showDashboardLinks" class="navigation-toolbar-link no-zoom"
                    :href="route('creator.campaigns.timelines.index', { campaign: campaignStore.campaignId })"
                    @click="toggleNavMenu(false)">
                <font-awesome-icon :icon="['fas', 'timeline']" fixed-width class="text-xl"></font-awesome-icon>Timelines
                </Link>

                <Link v-if="showDashboardLinks" class="navigation-toolbar-link no-zoom"
                    :href="route('creator.campaigns.characters.index', { campaign: campaignStore.campaignId })"
                    @click="toggleNavMenu(false)">
                <font-awesome-icon :icon="['fas', 'user']" fixed-width
                    class="text-xl"></font-awesome-icon><span>Characters</span>
                </Link>

                <Link class="navigation-toolbar-link no-zoom" :href="route('dice-roller')"
                    @click="toggleNavMenu(false)">
                <font-awesome-icon :icon="['fas', 'dice-d20']" fixed-width
                    class="text-xl"></font-awesome-icon><span>Dice
                    Roller</span>
                </Link>

                <Link v-if="!usePage().props.auth.user" class="navigation-toolbar-link no-zoom" :href="route('login')">
                <font-awesome-icon :icon="['fas', 'right-to-bracket']" fixed-width
                    class="text-xl"></font-awesome-icon><span>Log
                    In</span>
                </Link>

                <Link v-if="!usePage().props.auth.user" class="navigation-toolbar-link no-zoom"
                    :href="route('register')">
                <font-awesome-icon :icon="['fas', 'star']" fixed-width
                    class="text-xl"></font-awesome-icon><span>Register</span>
                </Link>

                <div v-if="!usePage().props.auth.user"></div>

                <button v-if="showDashboardLinks" type="button"
                    class="flex flex-col items-center gap-1 text-woodsmoke-950 dark:text-white-lilac-50 py-3 underline text-center transition-colors duration-theme-change no-zoom"
                    @click="toggleNavMenu()"><font-awesome-icon :icon="['fas', 'bars']" fixed-width
                        class="text-xl"></font-awesome-icon><span>Menu</span></button>
            </nav>
        </div>
    </div>
</template>

<style>

    .toolbar-navigation-slide-enter-from,
    .toolbar-navigation-slide-leave-to {
        opacity: 0;
        transform: translateY(100%);
    }

    .toolbar-navigation-slide-enter-to,
    .toolbar-navigation-slide-leave-from {
        opacity: 1;
        transform: translateY(0%);
    }

    .toolbar-navigation-slide-enter-active,
    .toolbar-navigation-slide-leave-active {
        transition: opacity transform;
        transition-duration: 0.3s;
        transition-timing-function: linear;
        transition-delay: 0;
    }
</style>