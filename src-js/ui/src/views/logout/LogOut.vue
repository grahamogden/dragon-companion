<template>
  <div>
    <button @click="logOut">Log out</button>
  </div>
</template>

<script setup lang="ts">
import { inject, ref, watchEffect } from 'vue' // used for conditional rendering
import { getAuth, signOut } from 'firebase/auth'
import { useRouter } from 'vue-router'
import { firebaseAppKey } from '../../keys';
import { useCampaignStore } from '../../stores/campaign';

const router = useRouter()

const logOut = () => {
  const auth = getAuth(inject(firebaseAppKey));

  signOut(auth).then(() => {
    // Sign-out successful.
    console.debug(('Logged out'));
    const campaignStore = useCampaignStore()
    campaignStore.$reset()

    router.push('/login')
  }).catch((error) => {
    // An error happened.
    console.error(error, {depth: 10})
  });
}
</script>
