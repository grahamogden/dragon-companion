<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { inject, ref } from 'vue'
import { getAuth, createUserWithEmailAndPassword } from 'firebase/auth'
import { useRouter } from 'vue-router'
import { firebaseAppKey } from '../../keys';

const email = ref('')
const password = ref('')
const router = useRouter()

const register = () => {
  const auth = getAuth(inject(firebaseAppKey))

  createUserWithEmailAndPassword(auth, email.value, password.value)
    .then((data) => {
      console.debug(data, { depth: 10 })
      router.push('/profile')
    })
    .catch((error) => {
      console.error(error, { depth: 10 })
    })
}
</script>
