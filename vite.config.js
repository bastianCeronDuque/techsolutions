import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/landing/register.css',
                'resources/css/landing/login.css',
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
