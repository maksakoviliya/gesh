<script setup>
	import { Link } from '@inertiajs/vue3'
	const props = defineProps({
		links: {
			type: Object,
		},
	})
</script>

<template>
	<nav v-if="props.links.length > 3">
		<ul
			class="flex items-center text-sm border border-neutral-200 dark:border-slate-700 rounded-lg overflow-hidden divide-x dark:divide-slate-700"
		>
			<li
				v-for="(link, i) in props.links"
				:key="i"
			>
				<span
					v-if="!link.url"
					v-html="link.label"
					class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white dark:bg-slate-800 dark:text-gray-400"
				></span>
				<Link
					v-else
					:href="link.url"
					v-html="link.label"
					class="flex items-center justify-center px-3 h-8"
					:class="
						link.active
							? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white'
							: 'ms-0 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
					"
				></Link>
			</li>
		</ul>
	</nav>
</template>
