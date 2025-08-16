import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/landing/login.css',
                'resources/js/landing/login.js',
                'resources/css/landing/register.css',
                'resources/js/landing/register.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    // Fix común para Windows
    server: {
        watch: {
            usePolling: true,
        },
    },
});
