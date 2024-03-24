<script setup lang="ts">
import { getAuth, signInWithEmailAndPassword, setPersistence, browserLocalPersistence, type UserCredential } from 'firebase/auth'
import { inject, ref } from 'vue'
import { useRouter } from 'vue-router'
import { firebaseAppKey } from '../../keys';

const email = ref('dragon.companion.app@gmail.com')
const password = ref('password123')
const router = useRouter()

const logIn = () => {
  const auth = getAuth(inject(firebaseAppKey))

  setPersistence(auth, browserLocalPersistence)
    .then(() => {
      signInWithEmailAndPassword(auth, email.value, password.value)
        .then((data: UserCredential) => {
          router.push('/profile')
        })
        .catch((error) => {
          console.error(error)
        })
    })
    .catch((error) => {
      console.error(error)
    })
}
</script>

<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="logIn">
      <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>
