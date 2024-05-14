<script setup lang="ts">
  import { inject, ref } from 'vue'
  import { getAuth, createUserWithEmailAndPassword, sendEmailVerification, setPersistence, browserLocalPersistence, type UserCredential, signOut } from 'firebase/auth'
  import { firebaseAppKey } from '../../keys';
  import { useUserAuthStore } from '../../stores'
  import TextInput from '../../components/elements/TextInput.vue'
  import PasswordInput from '../../components/elements/PasswordInput.vue'
  import PrimaryButton from '../../components/elements/PrimaryButton.vue'
  import { useRouter } from 'vue-router';

  const username = ref('TheDragon')
  const email = ref('dragon.companion.app@gmail.com')
  const password = ref('password123')
  const router = useRouter()

  const register = () => {
    const auth = getAuth(inject(firebaseAppKey))
    console.debug('Registering user')
    console.debug(auth.currentUser)


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
      })
      .catch((error) => {
        console.error(error)
      })
  }
</script>

<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <TextInput input-name="username" label="Username" v-model="username" />
      <TextInput input-name="email" label="Email" v-model="email" />
      <PasswordInput input-name="password" label="Password" v-model="password" />
      <!-- <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div> -->
      <!-- <div>
        <label>Password:</label>
        <input type="password" v-model="password" required />
      </div> -->
      <!-- <button class="primary-button" type="submit">Login</button> -->
      <div class="mt-10 flex flex-col md:flex-row justify-center gap-x-10 gap-y-6">
        <div class="md:order-last">
          <PrimaryButton text="Register" />
        </div>
        <div class="w-full md:w-auto text-center"><router-link :to="{ name: 'home' }" class="my-2">Cancel</router-link>
        </div>
      </div>
    </form>
  </div>
</template>
