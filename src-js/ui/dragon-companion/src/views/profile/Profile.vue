<script setup lang="ts">
import { inject, ref } from 'vue';
import { firebaseAppKey } from '../../keys';
import { getAuth, onAuthStateChanged } from 'firebase/auth';
import type { FirebaseApp } from 'firebase/app';
import { useUserAuthStore } from '../../stores';

const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
const auth = getAuth(firebaseApp);
// const currentUser = auth.currentUser
const userAuth = useUserAuthStore()
const idToken = ref('')

if(userAuth.getUser !== null) {
  console.debug(userAuth)
  userAuth.getUser.getIdToken()
    .then((token) => {
      idToken.value = token
    })
    .catch((error) => {
      console.error(error, {depth: 10})
    })

  onAuthStateChanged(auth, (user) => {
    userAuth.setUser(user)
  })
} else {
  console.debug('No user found')
}

</script>

<template>
  <div>
    <h2>User Profile</h2>
    <pre v-if="userAuth.getUser !== null" style="word-break: break-all; word-wrap: break-word; white-space: break-spaces;">{{ userAuth.getUser.email }} - {{ userAuth.getUser.uid }}:
{{ idToken }}</pre>
    <p v-else>You are not <router-link :to="{ name: 'login' }">logged in</router-link>.</p>
  </div>
</template>
