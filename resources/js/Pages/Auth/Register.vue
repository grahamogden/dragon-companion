<script setup lang="ts">
  import PrimaryButton from '../../Components/buttons/PrimaryButton.vue'
  import PageHeader from '../../Components/page-header/PageHeader.vue'
  import BaseInput from '../../Components/Fields/BaseInput.vue';
  import { Head, Link, useForm } from '@inertiajs/vue3'
  import BaseLayout from '../../Layouts/BaseLayout.vue';
  import SimpleContainerSlimLayout from '../../Layouts/SimpleContainerSlimLayout.vue';

  defineOptions({
    layout: [BaseLayout, SimpleContainerSlimLayout],
  })

  const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
  });

  // const register = () => {
  //   const auth = getAuth(inject(firebaseAppKey))
  //   console.debug('Registering user')

  //   try {
  //     setPersistence(auth, browserLocalPersistence)
  //       .then(() => {
  //         createUserWithEmailAndPassword(auth, email.value, password.value)
  //           .then((data: UserCredential) => {
  //             // signInWithEmailAndPassword(auth, email.value, password.value)
  //             //   .then((data: UserCredential) => {
  //             if (data.user) {
  //               const userAuthStore = useUserAuthStore()
  //               try {
  //                 userAuthStore.addUser(
  //                   {
  //                     username: username.value,
  //                     external_user_id: data.user.uid
  //                   },
  //                   data.user
  //                 );

  //                 // TODO: need to get the verification email to bring the user back
  //                 const actionCodeSettings = {
  //                   url: import.meta.env.VITE_API_BASE_URL + '/user?action=verify'
  //                 }
  //                 sendEmailVerification(data.user)
  //                   .then(() => {
  //                     router.push({ name: 'user-verify' })
  //                   })
  //               } catch (e) {
  //                 console.debug('something went wrong adding user')
  //                 console.debug(e)
  //                 signOut(auth)
  //                 userAuthStore.$reset()
  //               }
  //             }
  //           })
  //           .catch((error) => {
  //             console.error('Something wrong with create')
  //             console.error(error)
  //             if (error instanceof FirebaseError) {
  //               console.debug('Is firebase error')
  //               if (error.code === AuthErrorCodes.EMAIL_EXISTS) {
  //                 signInWithEmailAndPassword(auth, email.value, password.value).then((data: UserCredential) => {
  //                   const userAuthStore = useUserAuthStore()
  //                   userAuthStore.addUser(
  //                     {
  //                       username: username.value,
  //                       external_user_id: data.user.uid
  //                     },
  //                     data.user
  //                   );
  //                 })
  //               }
  //             }
  //           })
  //       })
  //       .catch((error) => {
  //         console.error('Something wrong with persist')
  //         console.error(error)
  //         if (error instanceof FirebaseError) {
  //           console.debug(error.code)
  //         }
  //       })
  //   } catch (error) {
  //     console.error('Something really broke')
  //     console.error(error)
  //   }
  // }
  const submit = () => {
    form.post(route('register'), {
    });
  }
</script>

<template>

  <Head title="Register" />
  <PageHeader>Register</PageHeader>
  <form @submit.prevent="submit" class="flex flex-col gap-default md:gap-default-md">
    <BaseInput type="text" input-name="username" label="Username" v-model:model="form.username"
      :error="form.errors.username"></BaseInput>
    <BaseInput type="email" input-name="email" label="Email" v-model:model="form.email" :error="form.errors.email">
    </BaseInput>
    <BaseInput type="password" input-name="password" label="Password" v-model:model="form.password"
      :error="form.errors.password"></BaseInput>
    <BaseInput type="password" input-name="password_confirmation" label="Password"
      v-model:model="form.password_confirmation" :error="form.errors.password_confirmation"></BaseInput>
    <div class="mt-10 flex flex-col md:flex-row justify-center gap-x-10 gap-y-default md:gap-y-default-md">
      <div class="md:order-last">
        <PrimaryButton text="Register"></PrimaryButton>
      </div>
      <div class="w-full md:w-auto text-center">
        <Link href="/" class="my-2">Cancel</Link>
      </div>
    </div>
  </form>
</template>
