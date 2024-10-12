import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import Components from 'unplugin-vue-components/vite'
import { PrimeVueResolver } from '@primevue/auto-import-resolver';
import tailwindcss from 'tailwindcss'

export default defineConfig((mode) => {
    const env = loadEnv(mode, process.cwd());
    const host = `${env.VITE_HOST ?? ''}`;

    return {
        server: {
            hmr: {
                host: host
            }
        },
        plugins: [
            laravel({
                input: ['resources/js/app.ts'],
                refresh: true,
                postcss: [
                    tailwindcss(),
                    autoprefixer(),
                ],
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            Components({
                resolvers: [
                    PrimeVueResolver()
                ]
            })
        ],
    }
});
