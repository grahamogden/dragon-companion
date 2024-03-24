import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProfileView from '../views/profile/Profile.vue'
import LogInView from '../views/login/LogIn.vue'
import LogOutView from '../views/logout/LogOut.vue'
import RegisterView from '../views/register/Register.vue'

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
            children: [
                {
                    path: 'edit',
                    name: 'campaigns.edit',
                    component: () => import('../views/campaigns/CampaignEdit.vue'),
                },
                {
                    path: 'characters',
                    name: 'characters',
                    // route level code-splitting
                    // this generates a separate chunk (About.[hash].js) for this route
                    // which is lazy-loaded when the route is visited.
                    component: () => import('../views/characters/CharacterList.vue'),
                },
                {
                    path: 'classes',
                    name: 'classes',
                    component: () => import('../views/classes/ClassList.vue'),
                },
                {
                    path: 'combat-encounters',
                    name: 'combat-encounters',
                    component: () => import('../views/combat-encounters/CombatEncounterList.vue'),
                },
                {
                    path: 'species',
                    name: 'species',
                    component: () => import('../views/species/SpeciesList.vue'),
                },
                {
                    path: 'timelines',
                    name: 'timelines',
                    component: () => import('../views/timelines/TimelineList.vue'),
                },
            ],
        },
        {
            path: '/campaigns',
            children: [
                {
                    path: '',
                    name: 'campaigns.list',
                    component: () => import('../views/campaigns/CampaignList.vue'),
                },
                {
                    path: 'add',
                    name: 'campaigns.add',
                    component: () => import('../views/campaigns/CampaignCreate.vue'),
                },
                // {
                //     path: 'edit/:externalCampaignId(\\d+)',
                //     name: 'campaign.edit',
                //     component: () => import('../views/campaigns/CampaignEdit.vue'),
                // },
            ],
        },
        // {
        //     path: '/campaigns',
        //     children: [
        //         //     // {
        //         //     //   path: 'delete/:externalCampaignId(\\d+)',
        //         //     //   name: 'campaign.delete',
        //         //     //   component: CampaignCreate,
        //         //     // },
        //         {
        //             path: 'add',
        //             name: 'campaigns.add',
        //             component: () => import('../views/campaigns/CampaignCreate.vue'),
        //         },
        //     ],
        // },
        {
            path: '/profile',
            name: 'profile',
            component: ProfileView,
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
        {
            path: '/register',
            name: 'register',
            component: RegisterView,
        },
    ],
})

export default router
