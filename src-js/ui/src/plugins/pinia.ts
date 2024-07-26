import { createPinia } from 'pinia'
import { type FirebaseApp } from 'firebase/app'
import { getAuth } from 'firebase/auth'
import RestClientService from '../services/repository/rest/RestClientService'
import { firebaseAppKey } from '../keys'
import { inject, markRaw } from 'vue'

// const firebaseApp = initializeApp(firebaseConfig)
const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
const auth = getAuth(firebaseApp)

// export default createPinia()
const pinia = createPinia()

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
export default pinia
