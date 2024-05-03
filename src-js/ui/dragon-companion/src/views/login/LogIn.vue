<script setup lang="ts">
import { getAuth, signInWithEmailAndPassword, setPersistence, browserLocalPersistence, type UserCredential } from 'firebase/auth'
import { inject, ref } from 'vue'
import { useRouter } from 'vue-router'
import { firebaseAppKey } from '../../keys';
import TextInput from '../../components/elements/TextInput.vue';
import PasswordInput from '../../components/elements/PasswordInput.vue';
import PrimaryButton from '../../components/elements/PrimaryButton.vue'
import LinkButton from '../../components/elements/LinkButton.vue'

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
    <h1 class="">Login</h1>
    <form @submit.prevent="logIn" class="flex flex-col">
      <!-- <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input type="password" v-model="password" required />
      </div> -->
      <TextInput input-name="email" label="Email" v-model="email" />
      <PasswordInput input-name="password" label="Password" v-model="password" />
      <!-- <button class="primary-button" type="submit">Login</button> -->
      <div class="mt-10">
          <PrimaryButton text="Save" />
          <LinkButton text="Cancel" :destination="{ name: 'home' }" />
      </div>
    </form>
  </div>
</template>
