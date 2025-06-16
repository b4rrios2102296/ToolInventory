import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    optimizeDeps: {
    include: [
      '@google/fonts',
    ],
  },

    server: {
    host: '0.0.0.0', // Permite acceso externo
    hmr: {
        host: '192.168.130.90', // Ej: '192.168.1.5'
    },
},
});
