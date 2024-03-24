import './assets/main.css'

import { createApp, markRaw } from 'vue'
import { createPinia } from 'pinia'
import { initializeApp } from 'firebase/app'
import App from './App.vue'
import router from './router'
import { firebaseAppKey } from './keys'
import { getAuth } from 'firebase/auth'
import RestClientService from './services/repository/rest/RestClientService'

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
}

// Initialize Firebase
const firebaseApp = initializeApp(firebaseConfig)

const app = createApp(App)
const pinia = createPinia()

const baseUrl = import.meta.env.VITE_API_BASE_URL
console.debug(baseUrl)
const auth = getAuth(firebaseApp)

pinia.use(({ store }) => {
    store.restClient = markRaw(new RestClientService(baseUrl, auth))
})

app.use(createPinia())
app.use(router)
app.use(pinia)

app.provide(firebaseAppKey, firebaseApp)

app.mount('#app')
