import { defineConfig } from "vite";
import Components from "unplugin-vue-components/vite";
import { AntDesignVueResolver } from "unplugin-vue-components/resolvers";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { VitePWA } from 'vite-plugin-pwa';
import path from "path";

export default defineConfig({
    plugins: [
        Components({
            resolvers: [
                AntDesignVueResolver({
                    importStyle: false, // css in js
                }),
            ],
        }),
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'Sampah Bijak',
                short_name: 'App',
                theme_color: '#ffffff',
                icons: [
                    {
                        src: '/images/192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/images/512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ],
                start_url: '/',
                display: 'standalone',
                background_color: '#ffffff'
            },
            workbox: {
                navigateFallback: '/',
                globPatterns: ['**/*.{js,css,html,ico,png,svg,webp}']
            }
        }),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
            assets: path.resolve(__dirname, "public/assets"),
            "ziggy-js": path.resolve(__dirname, "vendor/tightenco/ziggy"),
        },
    },
});
