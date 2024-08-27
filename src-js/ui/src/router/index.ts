import { inject } from 'vue'
import { createRouter, createWebHistory, type RouteLocationNormalized } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserAccountView from '../views/users/account/UserAccount.vue'
import LogInView from '../views/login/LogIn.vue'
import LogOutView from '../views/logout/LogOut.vue'
import { useCampaignStore, useUserAuthStore } from '../stores'
import { getAuth } from 'firebase/auth'
import { firebaseAppKey } from '../keys'
import type { FirebaseApp } from 'firebase/app'
import { useAuth } from '@vueuse/firebase'
import { useNotificationStore } from '../stores/notifications/notification-store'

function isLoggedIn(to: RouteLocationNormalized, from: RouteLocationNormalized) {
    const userAuthStore = useUserAuthStore()
    // const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
    // const auth = getAuth(firebaseApp)
    // const { isAuthenticated, user } = useAuth(auth)
    // console.debug('running is logged in for routing')
    // console.debug(isAuthenticated.value)
    // console.debug(userAuthStore.isLoggedIn)
    if (!userAuthStore.isLoggedIn) {
        console.debug('User is not logged in, redirecting to login')
        return { name: 'login' }
    }
}

function hasCampaignSelected(to: RouteLocationNormalized, from: RouteLocationNormalized) {
    const campaignStore = useCampaignStore()
    // console.debug(campaignStore)
    const storeCampaignId = campaignStore.selectedCampaignId
    // console.debug(storeCampaignId)
    const paramCampaignId = to.params.externalCampaignId
        ? parseInt(to.params.externalCampaignId as string)
        : null
    // console.debug(paramCampaignId)

    if (storeCampaignId === paramCampaignId) {
        return
    }

    if (!paramCampaignId) {
        console.debug('User has not selected a campaign, redirecting to campaigns.list')
        return { name: 'campaigns.list' }
    }

    campaignStore.selectCampaign(paramCampaignId)
}

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
        },
        {
            path: '/campaigns/:externalCampaignId(\\d+)',
            beforeEnter: isLoggedIn,
            children: [
                {
                    path: 'edit',
                    name: 'campaigns.edit',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/campaigns/CampaignEdit.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                {
                    path: 'view',
                    name: 'campaigns.view',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/campaigns/CampaignView.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                {
                    path: 'classes',
                    name: 'classes',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    component: () => import('../views/classes/ClassList.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                // {
                //     path: 'combat-encounters',
                //     name: 'combat-encounters',
                //     beforeEnter: [isLoggedIn, hasCampaignSelected],
                //     component: () => import('../views/combat-encounters/CombatEncounterList.vue'),
                //     meta: {
                //         layout: 'Dashboard',
                //     },
                // },
                {
                    path: 'tags',
                    name: 'tags',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    component: () => import('../views/timelines/TimelineList.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                {
                    path: 'characters',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    children: [
                        {
                            path: '',
                            name: 'characters.list',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/characters/CharacterList.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: 'add',
                            name: 'characters.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/characters/CharacterCreate.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':characterId(\\d+)/edit',
                            name: 'characters.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/characters/CharacterEdit.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':characterId(\\d+)/view',
                            name: 'characters.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/characters/CharacterView.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                    ],
                },
                {
                    path: 'items',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    children: [
                        {
                            path: '',
                            name: 'items.list',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/items/ItemList.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: 'add',
                            name: 'items.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/items/ItemCreate.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':itemId(\\d+)/edit',
                            name: 'items.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/items/ItemEdit.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':itemId(\\d+)/view',
                            name: 'items.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/items/ItemView.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                    ],
                },
                {
                    path: 'monsters',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    children: [
                        {
                            path: '',
                            name: 'monsters.list',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/monsters/MonsterList.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: 'add',
                            name: 'monsters.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/monsters/MonsterCreate.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':monsterId(\\d+)/edit',
                            name: 'monsters.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/monsters/MonsterEdit.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':monsterId(\\d+)/view',
                            name: 'monsters.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/monsters/MonsterView.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                    ],
                },
                {
                    path: 'species',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    children: [
                        {
                            path: '',
                            name: 'species.list',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesList.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: 'add',
                            name: 'species.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesCreate.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':speciesId(\\d+)/edit',
                            name: 'species.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesEdit.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':speciesId(\\d+)/view',
                            name: 'species.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesView.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                    ],
                },
                {
                    path: 'timelines',
                    name: 'timelines',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    children: [
                        {
                            path: '',
                            name: 'timelines.list',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineList.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: 'add',
                            name: 'timelines.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineCreate.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':timelineId(\\d+)/edit',
                            name: 'timelines.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineEdit.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                        {
                            path: ':timelineId(\\d+)/view',
                            name: 'timelines.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineView.vue'),
                            meta: {
                                layout: 'Dashboard',
                            },
                        },
                    ],
                },
            ],
        },
        {
            path: '/campaigns',
            beforeEnter: isLoggedIn,
            children: [
                {
                    path: '',
                    name: 'campaigns.list',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/campaigns/CampaignList.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                {
                    path: 'add',
                    name: 'campaigns.add',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/campaigns/CampaignCreate.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
            ],
        },
        {
            path: '/dice-roller',
            children: [
                {
                    path: '',
                    name: 'dice-roller',
                    component: () => import('../views/dice-roller/DiceRoller.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
            ],
        },
        {
            path: '/users',
            children: [
                {
                    path: 'account',
                    name: 'user-account',
                    component: UserAccountView,
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                {
                    path: 'verify',
                    name: 'user-verify',
                    component: () => import('../views/users/verify/UserVerify.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
                {
                    path: 'register',
                    name: 'user-register',
                    component: () => import('../views/register/Register.vue'),
                    meta: {
                        layout: 'Dashboard',
                    },
                },
            ],
        },
        {
            path: '/login',
            name: 'login',
            component: LogInView,
            meta: {
                layout: 'Dashboard',
            },
        },
        {
            path: '/logout',
            name: 'logout',
            component: LogOutView,
            meta: {
                layout: 'Dashboard',
            },
        },
    ],
})

router.afterEach(() => {
    const notificationStore = useNotificationStore()
    notificationStore.removeAllNotifications()
})

export default router
