import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CampaignList from '../views/campaigns/CampaignList.vue'
// import CharacterList from
// import ClassList from
// import CombatEncounterList from
// import SpeciesList from
// import TimelineList from

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/campaign/:externalCampaignId',
      name: 'campaign',
      component: CampaignList,
      children: [
        {
          path: '/character',
          name: 'character',
          // route level code-splitting
          // this generates a separate chunk (About.[hash].js) for this route
          // which is lazy-loaded when the route is visited.
          component: () => import('../views/characters/CharacterList.vue'),
        },
        {
          path: '/class',
          name: 'class',
          component: () => import('../views/classes/ClassList.vue'),
        },
        {
          path: '/combat-encounter',
          name: 'combat-encounter',
          component: () => import('../views/combat-encounters/CombatEncounterList.vue'),
        },
        {
          path: '/species',
          name: 'species',
          component: () => import('../views/species/SpeciesList.vue'),
        },
        {
          path: '/timeline',
          name: 'timeline',
          component: () => import('../views/timelines/TimelineList.vue'),
        },
      ],
    },
  ],
})

export default router
