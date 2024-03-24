<script setup lang="ts">
import { inject, ref } from 'vue'
import { RouterLink, RouterView, useRouter } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
import { getAuth, onAuthStateChanged, signOut } from 'firebase/auth'
import { firebaseAppKey } from './keys'
import type { FirebaseApp } from 'firebase/app'
import { useCampaignStore } from './stores/campaign'
import CampaignPicker from './components/campaign-picker/CampaignPicker.vue'

const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
const auth = getAuth(firebaseApp);
const isLoggedIn = ref(false)
const campaignStore = useCampaignStore()

onAuthStateChanged(
  auth,
  (user) => {
    isLoggedIn.value = user !== null
    if(user !== null) {
      user.getIdToken()
        .then((idToken) => {
          console.dir('Is logged in!')
        })
        .catch((error) => {
          console.error(error)
        })
    } else {
      campaignStore.reset()
      console.debug('Reset campaign storage')
    }
  }
)

const router = useRouter()

const logOut = () => {
  const auth = getAuth(inject(firebaseAppKey));

  signOut(auth).then(() => {
    console.debug(('Logged out'));
    campaignStore.reset()

    router.push('/login')
  }).catch((error) => {
    console.error(error)
  });
}

</script>
<template>
  <a href="#main-content">Skip to main content</a>
  <header>
    <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />

    <div class="wrapper">
      <HelloWorld msg="You did it!" />

      <nav>
        <router-link to="/">Home!</router-link>
        <router-link v-if="!isLoggedIn" to="/register">Register</router-link>
        <router-link v-if="!isLoggedIn" to="/login">Log In</router-link>
        <router-link v-if="isLoggedIn" to="/profile">Profile</router-link>
        <a v-if="isLoggedIn" @click="logOut">Log Out</a>
        <router-link :to="{ name: 'campaigns.list' }">Campaigns</router-link>
        <router-link v-if="campaignStore.isCampaignSelected" :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId }}">Characters</router-link>
        <router-link v-if="campaignStore.isCampaignSelected" :to="{ name: 'classes', params: { externalCampaignId: campaignStore.campaignId }}">Classes</router-link>
        <router-link v-if="campaignStore.isCampaignSelected" :to="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId }}">Combat Encounters</router-link>
        <router-link v-if="campaignStore.isCampaignSelected" :to="{ name: 'species', params: { externalCampaignId: campaignStore.campaignId }}">Species</router-link>
        <router-link v-if="campaignStore.isCampaignSelected" :to="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId }}">Timelines</router-link>
      </nav>
      <CampaignPicker />
    </div>
  </header>

  <main id="main-content">
    <RouterView />
  </main>
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
