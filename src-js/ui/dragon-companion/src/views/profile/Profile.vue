<script setup lang="ts">
import { inject, ref } from 'vue';
import { firebaseAppKey } from '../../keys';
import { getAuth } from 'firebase/auth';
import type { FirebaseApp } from 'firebase/app';

const firebaseApp: FirebaseApp = inject(firebaseAppKey)!

const currentUser = getAuth(firebaseApp).currentUser
const idToken = ref('')

if(currentUser !== null) {
  currentUser.getIdToken()
    .then((token) => {
      idToken.value = token
    })
    .catch((error) => {
      console.error(error, {depth: 10})
    })
} else {
  console.debug('No user found')
}

</script>

<template>
  <div>
    <h2>User Profile</h2>
    <pre v-if="currentUser !== null" style="word-break: break-all; word-wrap: break-word; white-space: break-spaces;">{{ currentUser.email }} - {{ currentUser.uid }}:
{{ idToken }}</pre>
    <p v-else>You are not <router-link :to="{ name: 'login' }">logged in</router-link>.</p>
  </div>
</template>
