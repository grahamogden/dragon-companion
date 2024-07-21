/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
// import '@/styles/main.scss'
import { customLight as CustomLight } from '../themes/custom-light'
import { customDark as CustomDark } from '../themes/custom-dark'

// Composables
import { createVuetify } from 'vuetify'

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
    theme: {
        themes: {
            customLight: CustomLight,
            customDark: CustomDark,
        },
    },
})
