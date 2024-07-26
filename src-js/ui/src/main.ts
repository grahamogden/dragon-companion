import './assets/main.css'

import { createApp, type App as AppType, inject } from 'vue'
import { type FirebaseApp } from 'firebase/app'
import App from './App.vue'
import { firebaseAppKey } from './keys'
import { getAuth } from 'firebase/auth'
import { registerPlugins } from './plugins'

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

const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
const auth = getAuth(firebaseApp)

let app: AppType | undefined

auth.onAuthStateChanged(() => {
    if (!app) {
        app = createApp(App)
        registerPlugins(app)

        document.getElementById('app')?.classList.remove('loading')
        app.mount('#app')
    }
})
