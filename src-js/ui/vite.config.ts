import { fileURLToPath, URL } from 'node:url'
import { readFileSync } from 'node:fs'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

// https://vitejs.dev/config/
export default defineConfig(({ command, mode }) => {
    return {
        base: 'ui',
        plugins: [vue(), vueJsx()],
        resolve: {
            alias: {
                '@': fileURLToPath(new URL('./src', import.meta.url)),
            },
        },
        server: {
            host: 'dragon-companion.develop',
            https: {
                key: readFileSync('../../build/private/dragon-companion.key'),
                cert: readFileSync('../../build/certs/dragon-companion.crt'),
            },
        },
        build: {
            outDir: '../../webroot/ui/dist'
        }
    }
})
