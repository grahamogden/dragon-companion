<script setup lang="ts">
  import { getAuth, signInWithEmailAndPassword, setPersistence, type UserCredential, browserLocalPersistence } from 'firebase/auth'
  import { inject, ref } from 'vue'
  import { useRouter, RouterLink } from 'vue-router'
  import { firebaseAppKey } from '../../keys'
  import TextInput from '../../components/fields/TextInput.vue'
  import PasswordInput from '../../components/fields/PasswordInput.vue'
  import PrimaryButton from '../../components/buttons/PrimaryButton.vue'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import BaseInput from '../../components/fields/BaseInput.vue'

  const email = ref('dragon.companion.app@gmail.com')
  const password = ref('password123')
  const router = useRouter()

  const logIn = () => {
    const auth = getAuth(inject(firebaseAppKey))

    setPersistence(auth, browserLocalPersistence)
      .then(() => {
        signInWithEmailAndPassword(auth, email.value, password.value)
          .then((data: UserCredential) => {
            router.push('campaigns')
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
    <PageHeader>Log in</PageHeader>
    <form @submit.prevent="logIn" class="flex flex-col gap-6">
      <BaseInput type="email" input-name="email" label="Email" v-model:model="email"></BaseInput>
      <BaseInput type="password" input-name="password" label="Password" v-model:model="password"></BaseInput>
      <div class="mt-10 flex flex-col md:flex-row justify-center gap-x-10 gap-y-6">
        <div class="md:order-last">
          <PrimaryButton text="Log in"></PrimaryButton>
        </div>
        <div class="w-full md:w-auto text-center">
          <RouterLink :to="{ name: 'home' }" class="my-2">Cancel</RouterLink>
        </div>
      </div>
    </form>
  </div>
</template>
