import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/frontend/app.css',     // ✅ Frontend
                'resources/css/admin/app.css',        // ✅ Admin (tambahkan ini)
                'resources/js/app.js',
                'resources/js/frontend/app.js',
                'resources/js/admin/app.js'           // ✅ Admin JS
            ],
            refresh: true,
        }),
    ],
});
