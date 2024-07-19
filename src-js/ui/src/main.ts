import './assets/main.css'

import { createApp, markRaw, type App as AppType } from 'vue'
import { createPinia } from 'pinia'
import { initializeApp } from 'firebase/app'
import App from './App.vue'
import router from './router'
import { firebaseAppKey } from './keys'
import { getAuth } from 'firebase/auth'
import RestClientService from './services/repository/rest/RestClientService'

function getCookie(key: string): string | null {
    const cookies = document.cookie.split('; ')
    let cookieValue = null
    cookies.forEach((cookie) => {
        const [name, value] = cookie.split('=')
        if (name === key) {
            cookieValue = decodeURIComponent(value)
        }
    })
    return cookieValue
}

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

const pinia = createPinia()

const auth = getAuth(firebaseApp)

const csrfTokenElem: HTMLDivElement | null = document.getElementById(
    'csrf-token',
) as HTMLDivElement | null
let csrfToken: string = ''
if (csrfTokenElem?.dataset.csrfToken) {
    csrfToken = csrfTokenElem.dataset.csrfToken
}

pinia.use(({ store }) => {
    store.restClient = markRaw(
        new RestClientService(import.meta.env.VITE_API_BASE_URL, auth, csrfToken),
    )
})

let app: AppType | undefined

auth.onAuthStateChanged(() => {
    if (!app) {
        app = createApp(App)
        app.use(createPinia())
        app.use(router)
        app.use(pinia)

        app.provide(firebaseAppKey, firebaseApp)

        document.getElementById('app')?.classList.remove('loading')
        app.mount('#app')
    }
})
