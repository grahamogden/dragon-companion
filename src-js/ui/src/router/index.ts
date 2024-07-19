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
                },
                {
                    path: 'view',
                    name: 'campaigns.view',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/campaigns/CampaignView.vue'),
                },
                {
                    path: 'characters',
                    name: 'characters',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    // route level code-splitting
                    // this generates a separate chunk (About.[hash].js) for this route
                    // which is lazy-loaded when the route is visited.
                    component: () => import('../views/characters/CharacterList.vue'),
                },
                {
                    path: 'classes',
                    name: 'classes',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    component: () => import('../views/classes/ClassList.vue'),
                },
                {
                    path: 'combat-encounters',
                    name: 'combat-encounters',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    component: () => import('../views/combat-encounters/CombatEncounterList.vue'),
                },
                {
                    path: 'tags',
                    name: 'tags',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    component: () => import('../views/timelines/TimelineList.vue'),
                },
                // {
                //     path: '/species',
                //     name: 'species',
                //     beforeEnter: isLoggedIn,
                //     component: () => import('../views/species/SpeciesList.vue'),
                // },
                {
                    path: 'species',
                    beforeEnter: [isLoggedIn, hasCampaignSelected],
                    children: [
                        {
                            path: '',
                            name: 'species.list',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesList.vue'),
                        },
                        {
                            path: 'add',
                            name: 'species.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesCreate.vue'),
                        },
                        {
                            path: ':speciesId(\\d+)/edit',
                            name: 'species.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesEdit.vue'),
                        },
                        {
                            path: ':speciesId(\\d+)/view',
                            name: 'species.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/species/SpeciesView.vue'),
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
                        },
                        {
                            path: 'add',
                            name: 'timelines.add',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineCreate.vue'),
                        },
                        {
                            path: ':timelineId(\\d+)/edit',
                            name: 'timelines.edit',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineEdit.vue'),
                        },
                        {
                            path: ':timelineId(\\d+)/view',
                            name: 'timelines.view',
                            beforeEnter: [isLoggedIn, hasCampaignSelected],
                            component: () => import('../views/timelines/TimelineView.vue'),
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
                },
                {
                    path: 'add',
                    name: 'campaigns.add',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/campaigns/CampaignCreate.vue'),
                },
            ],
        },
        {
            path: '/users',
            children: [
                { path: 'account', name: 'user-account', component: UserAccountView },
                {
                    path: 'verify',
                    name: 'user-verify',
                    component: () => import('../views/users/verify/UserVerify.vue'),
                },
                {
                    path: 'register',
                    name: 'user-register',
                    component: () => import('../views/register/Register.vue'),
                },
            ],
        },
        {
            path: '/login',
            name: 'login',
            component: LogInView,
        },
        {
            path: '/logout',
            name: 'logout',
            component: LogOutView,
        },
    ],
})

router.afterEach(() => {
    const notificationStore = useNotificationStore()
    notificationStore.$reset()
})

export default router
