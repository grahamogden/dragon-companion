<script setup lang="ts">
import { inject, ref } from 'vue';
import { firebaseAppKey } from '../../../keys';
import { getAuth, onAuthStateChanged } from 'firebase/auth';
import { type FirebaseApp } from 'firebase/app';
import { useUserAuthStore } from '../../../stores';

const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
const auth = getAuth(firebaseApp);
const userAuth = useUserAuthStore()
const idToken = ref('')

onAuthStateChanged(auth, (user) => {
  userAuth.setUser(user)
  user?.getIdToken()
  .then((token) => {
      console.debug(token)
      idToken.value = token
    })
    .catch((error) => {
      console.error(error, {depth: 10})
    })
})

</script>

<template>
  <div>
    <h2>User Profile</h2>
    <pre v-if="userAuth.getUser !== null">{{ userAuth.getUser.email }} - {{ userAuth.getUser.uid }}:
{{ idToken }}</pre>
    <p v-else>You are not <router-link :to="{ name: 'login' }">logged in</router-link>.</p>
  </div>
</template>
