import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: 'reeltrack-laravel.test',
        port: 5173,
        watch: true,
        cors: {
            origin: 'http://reeltrack-laravel.test'
        },
        hmr: {
            host: 'reeltrack-laravel.test',
        },

    }
});
