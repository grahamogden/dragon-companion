import { fileURLToPath, URL } from 'node:url'
import { readFileSync } from 'node:fs'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import vuetify from 'vite-plugin-vuetify'

// https://vitejs.dev/config/
export default defineConfig(({ command, mode }) => {
    return {
        base: 'ui',
        // css: {
        //     preprocessorOptions: {
        //         scss: {
        //             additionalData: `
        //                 @use "./src/styles/variables/_variables.scss";
        //             `,
        //         },
        //     },
        // },
        plugins: [
            vue(),
            vueJsx(),
            vuetify({
                autoImport: true,
                styles: { configFile: 'src/styles/settings.scss' },
            }), // 'none' }),
        ],
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
            outDir: '../../webroot/ui/dist',
            emptyOutDir: true,
        },
    }
})
