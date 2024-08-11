/**
 * plugins/index.ts
 *
 * Automatically included in `./src/main.ts`
 */

// Plugins
import firebaseApp from './firebase-app'
import pinia from './pinia'
import router from '../router'
import FontAwesomeIcon from './font-awesome'

// Types
import type { App } from 'vue'

// Keys
import { firebaseAppKey } from '../keys'

export function registerPlugins(app: App) {
    app.provide(firebaseAppKey, firebaseApp)
    app.use(router).use(pinia)
    app.component('font-awesome-icon', FontAwesomeIcon)
}
