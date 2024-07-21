import type { ThemeDefinition } from 'vuetify'
import { timberwolf50, woodsmoke950 } from './variables'

export const customLight: ThemeDefinition = {
    dark: false,
    colors: {
        'text-default': woodsmoke950,
        'bg-input-text-field': timberwolf50,
    },
}
