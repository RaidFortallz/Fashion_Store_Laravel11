import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                
                //Css
                'resources/views/themes/jawique/assets/css/main.css',
                'resources/views/themes/jawique/assets/plugins/jqueryui/jquery-ui.css',
                //Js
                'resources/views/themes/jawique/assets/js/main.js',
                'resources/views/themes/jawique/assets/plugins/jqueryui/jquery-ui.min.js',
            ],
            refresh: true,
        }),
    ],
});
