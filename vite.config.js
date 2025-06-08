import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                    'resources/js/app.js',
                    'resources/js/serverFetch.js',
                    'resources/css/navbar.css',
                    'resources/css/footer.css',
                    'resources/css/carousel.css',
                    'resources/css/search_bar.css',
                    'resources/css/listAnime.css',
                    'resources/css/details.css',
                    'resources/css/errors.css',
                    'resources/css/search.css',
                    'resources/css/watch.css',
                ],
            refresh: true,
        }),
    ],
});
