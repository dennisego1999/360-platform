import './bootstrap';
import '../scss/app.scss';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { router } from '@inertiajs/vue3';
import { createI18n } from 'vue-i18n';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

// Setup toast options
const options = {
	transition: 'Vue-Toastification__fade',
	maxToasts: 5,
	position: 'top-center',
	timeout: 5000,
	container: document.querySelector('#app'),
	pauseOnFocusLoss: true,
	pauseOnHover: true,
	closeOnClick: true,
	closeButton: 'button',
	icon: false,
	newestOnTop: true,
	draggable: true,
	draggablePercent: 0.6,
	showCloseButtonOnHover: false
};

// Create a new Vue app instance for Inertia
createInertiaApp({
	title: (title) => {
		const appName = import.meta.env.VITE_APP_NAME;

		if (!title) {
			return appName;
		}

		return `${title} - ${appName}`;
	},
	resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
	setup({ el, App, props, plugin }) {
		const i18n = createI18n({
			locale: props.initialPage.props.locales.find((locale) => locale.is_current)?.code,
			messages: props.initialPage.props.translations,
			legacy: false,
			warnHtmlMessage: false
		});

		return createApp({
			created() {
				router.on('invalid', (event) => {
					// Do not prevent the default behavior while developing
					if (process.env.NODE_ENV !== 'production') {
						return;
					}

					// Do not prevent the handler for server errors or validation checks
					if (event.detail.response.status === 500 || event.detail.response.status === 403) {
						return;
					}

					// Prevent a white modal
					event.preventDefault();

					// Log the invalid response info
					console.error('An invalid Inertia response was received.');
					console.error(event.detail.response);
				});
			},

			mounted() {
				// Remove the props to initialize Vue
				document.getElementById('app').removeAttribute('data-page');
			},

			render: () => h(App, props)
		})
			.use(plugin)
			.use(ZiggyVue)
			.use(Toast, options)
			.use(i18n)
			.mount(el);
	},
	progress: { color: 'var(--color-primary)' }
});
