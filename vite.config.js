import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

if (process.env.npm_config_user_agent && !process.env.npm_config_user_agent.startsWith('pnpm')) {
    console.error('\x1b[31m%s\x1b[0m', 'Error: Este proyecto utiliza exclusivamente pnpm. No se permite ejecutar comandos con npm.');
    console.error('\x1b[33m%s\x1b[0m', 'Por favor usa: pnpm run ' + (process.env.npm_lifecycle_event || 'dev'));
    process.exit(1);
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
