import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';

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
                input: 'resources/js/app.ts',
                refresh: true,
                postcss: [
                    // tailwindcss(),
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
        ],
    }
});
