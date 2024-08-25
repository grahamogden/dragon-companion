<script setup lang="ts">
  import { inject, ref } from 'vue'
  import { getAuth, createUserWithEmailAndPassword, sendEmailVerification, setPersistence, browserLocalPersistence, type UserCredential, signOut, AuthErrorCodes, signInWithEmailAndPassword } from 'firebase/auth'
  import { firebaseAppKey } from '../../keys';
  import { useUserAuthStore } from '../../stores'
  import TextInput from '../../components/fields/TextInput.vue'
  import PasswordInput from '../../components/fields/PasswordInput.vue'
  import PrimaryButton from '../../components/buttons/PrimaryButton.vue'
  import { useRouter } from 'vue-router';
  import { FirebaseError } from 'firebase/app';
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import BaseInput from '../../components/fields/BaseInput.vue';

  const username = ref('TheDragon')
  const email = ref('dragon.companion.app@gmail.com')
  const password = ref('password123')
  const router = useRouter()

  const register = () => {
    const auth = getAuth(inject(firebaseAppKey))
    console.debug('Registering user')

    try {
      setPersistence(auth, browserLocalPersistence)
        .then(() => {
          createUserWithEmailAndPassword(auth, email.value, password.value)
            .then((data: UserCredential) => {
              // signInWithEmailAndPassword(auth, email.value, password.value)
              //   .then((data: UserCredential) => {
              if (data.user) {
                const userAuthStore = useUserAuthStore()
                try {
                  userAuthStore.addUser(
                    {
                      username: username.value,
                      external_user_id: data.user.uid
                    },
                    data.user
                  );

                  // TODO: need to get the verification email to bring the user back
                  const actionCodeSettings = {
                    url: import.meta.env.VITE_API_BASE_URL + '/user?action=verify'
                  }
                  sendEmailVerification(data.user)
                    .then(() => {
                      router.push({ name: 'user-verify' })
                    })
                } catch (e) {
                  console.debug('something went wrong adding user')
                  console.debug(e)
                  signOut(auth)
                  userAuthStore.$reset()
                }
              }
            })
            .catch((error) => {
              console.error('Something wrong with create')
              console.error(error)
              if (error instanceof FirebaseError) {
                console.debug('Is firebase error')
                if (error.code === AuthErrorCodes.EMAIL_EXISTS) {
                  signInWithEmailAndPassword(auth, email.value, password.value).then((data: UserCredential) => {
                    const userAuthStore = useUserAuthStore()
                    userAuthStore.addUser(
                      {
                        username: username.value,
                        external_user_id: data.user.uid
                      },
                      data.user
                    );
                  })
                }
              }
            })
        })
        .catch((error) => {
          console.error('Something wrong with persist')
          console.error(error)
          if (error instanceof FirebaseError) {
            console.debug(error.code)
          }
        })
    } catch (error) {
      console.error('Something really broke')
      console.error(error)
    }
  }
</script>

<template>
  <div>
    <PageHeader>Register</PageHeader>
    <form @submit.prevent="register" class="flex flex-col gap-6">
      <BaseInput type="text" input-name="username" label="Username" v-model:model="username"></BaseInput>
      <BaseInput type="email" input-name="email" label="Email" v-model:model="email"></BaseInput>
      <BaseInput type="password" input-name="password" label="Password" v-model:model="password"></BaseInput>
      <div class="mt-10 flex flex-col md:flex-row justify-center gap-x-10 gap-y-6">
        <div class="md:order-last">
          <PrimaryButton text="Register"></PrimaryButton>
        </div>
        <div class="w-full md:w-auto text-center">
          <RouterLink :to="{ name: 'home' }" class="my-2">Cancel</RouterLink>
        </div>
      </div>
    </form>
  </div>
</template>
