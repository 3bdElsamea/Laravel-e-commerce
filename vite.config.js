import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import mix from "laravel-mix";

mix.js('resources/js/app.js', 'public/js')

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
            publicBase: '/public/',
        }),
    ],
});
