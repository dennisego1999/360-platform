import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

const config = {
	plugins: [
		laravel({
			input: 'resources/js/app.js',
			ssr: 'resources/js/ssr.js',
			refresh: true
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false
				}
			}
		})
	],
	resolve: {
		alias: {
			'@': '/resources/js'
		}
	}
};

export default defineConfig(config);
