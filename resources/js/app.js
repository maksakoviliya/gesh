import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { createYmaps } from 'vue-yandex-maps'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
	title: (title) => (!!title ? title : `${appName}`),
	resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
	setup({ el, App, props, plugin }) {
		return createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue)
			.use(
				createYmaps({
					apikey: '9fa90fbc-ce5f-4dc9-ae6d-433e0ec7338b',
				})
			)
			.mount(el)
	},
	progress: {
		color: '#4B5563',
	},
})
