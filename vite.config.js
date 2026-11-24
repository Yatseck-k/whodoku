import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/whodoku/js/app.ts', 'resources/whodoku/js/orchid-map-editor.ts'],
            buildDirectory: 'build/whodoku',
        }),
        vue(),
        i18n(),
        tailwindcss(),
    ],
    build: { rolldownOptions: { preserveEntrySignatures: 'strict' } },
});
