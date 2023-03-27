import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {resolve} from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'node_modules/animate.css/animate.css',
                'resources/vite/vendor/icheck/green.min.css',
                'resources/css/style.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/vite/vendor/icheck/icheck.min.js'
            ],
            refresh: true
        })
    ],
    resolve: {
        alias: {
            $fonts: resolve('./resources/vite/fonts'),
            $images: resolve('./public/images')
        }
    }
});