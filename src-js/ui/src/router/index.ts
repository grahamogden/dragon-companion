import { inject } from 'vue'
import { createRouter, createWebHistory, type RouteLocationPathRaw } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserAccountView from '../views/users/account/UserAccount.vue'
import LogInView from '../views/login/LogIn.vue'
import LogOutView from '../views/logout/LogOut.vue'
import { useUserAuthStore } from '../stores'
import { getAuth } from 'firebase/auth'
import { firebaseAppKey } from '../keys'
import type { FirebaseApp } from 'firebase/app'
import { useAuth } from '@vueuse/firebase'

function isLoggedIn(to: RouteLocationPathRaw, from: RouteLocationPathRaw) {
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
                    beforeEnter: isLoggedIn,
                    // route level code-splitting
                    // this generates a separate chunk (About.[hash].js) for this route
                    // which is lazy-loaded when the route is visited.
                    component: () => import('../views/characters/CharacterList.vue'),
                },
                {
                    path: 'classes',
                    name: 'classes',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/classes/ClassList.vue'),
                },
                {
                    path: 'combat-encounters',
                    name: 'combat-encounters',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/combat-encounters/CombatEncounterList.vue'),
                },
                {
                    path: 'species',
                    name: 'species',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/species/SpeciesList.vue'),
                },
                {
                    path: 'timelines',
                    name: 'timelines',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/timelines/TimelineList.vue'),
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
            beforeEnter: isLoggedIn,
            children: [
                { path: '/account', name: 'user-account', component: UserAccountView },
                {
                    path: '/verify',
                    name: 'user-verify',
                    beforeEnter: isLoggedIn,
                    component: () => import('../views/users/verify/UserVerify.vue'),
                },
                {
                    path: '/register',
                    name: 'user-register',
                    beforeEnter: isLoggedIn,
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

export default router
