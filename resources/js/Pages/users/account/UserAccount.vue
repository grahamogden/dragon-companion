<script setup lang="ts">
  import { inject, ref } from 'vue';
  import { firebaseAppKey } from '../../../keys';
  import { getAuth, onAuthStateChanged } from 'firebase/auth';
  import { type FirebaseApp } from 'firebase/app';
  import { useUserAuthStore } from '../../../stores';
  import PageHeader from '../../../components/page-header/PageHeader.vue';
  import ContentGroup from '../../../components/elements/ContentGroup.vue';
  import { Link } from '@inertiajs/vue3';

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
        console.error(error, { depth: 10 })
      })
  })

  const isCopied = ref(false)

  function copyToClipboard(event: Event) {
    let element = event.target as HTMLElement
    let target = element.getAttribute('data-target')
    if (!target) {
      target = element.parentElement!.getAttribute('data-target')
    }
    navigator.clipboard.writeText(document.getElementById(target!)!.innerText)
    isCopied.value = true
    setTimeout(() => {
      isCopied.value = false
    }, 1000)
  }
</script>

<template>
  <div>
    <page-header>User Profile</page-header>
    <div class="px-4" v-if="userAuth.getUser !== null">
      <content-group #content>{{ userAuth.getUser.email }} - {{ userAuth.getUser.uid
        }}:</content-group>
      <content-group #content>
        <button @click="copyToClipboard($event)" data-target="token" class="relative"><i class="fa fa-clipboard text-xl"
            :class="{ 'text-fern-500': isCopied }"></i>
          <div v-if="isCopied"
            class="absolute top-full left-2/4 -translate-x-2/4 mt-1 border border-shark-500 bg-shark-200 p-2 before:content-[''] before:absolute before:-top-1 before:left-2/4 before:w-2 before:h-2 before:-translate-x-2/4 before:border-t before:border-l before:rotate-45 before:border-shark-500 before:bg-shark-200">
            Copied!
          </div>
        </button>
        <pre id="token">{{ idToken }}</pre>
      </content-group>
    </div>
    <div class="px-4" v-else>
      <p>You are not
        <Link :href="route('login')">logged in</Link>.
      </p>
    </div>
  </div>
</template>
