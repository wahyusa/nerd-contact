import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

// Check if we're running in GitHub Codespace
const isCodespace = process.env.CODESPACES === 'true';
const codespaceUrl = isCodespace ? `https://${process.env.CODESPACE_NAME}-5173.${process.env.GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}` : undefined;
const laravelUrl = isCodespace
    ? `https://${process.env.CODESPACE_NAME}-8000.${process.env.GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}`
    : 'http://localhost:8000';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: {
            origin: [laravelUrl, 'http://localhost:8000'],
            credentials: true,
        },
        hmr: isCodespace
            ? {
                  host: `${process.env.CODESPACE_NAME}-5173.${process.env.GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}`,
                  clientPort: 443,
              }
            : {
                  port: 5173,
              },
        // Override the origin when in Codespace
        origin: codespaceUrl,
    },
});
