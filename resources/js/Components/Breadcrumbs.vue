<script setup>
	import { Link } from '@inertiajs/vue3'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { BiChevronRight } from 'oh-vue-icons/icons'

	defineProps({
		routes: Array,
	})
	addIcons(BiChevronRight)
</script>

<template>
	<div class="flex items-center gap-3 mt-10 whitespace-nowrap w-full overflow-auto no-scrollbar">
		<component
			:is="i < routes.length - 1 ? Link : 'div'"
			:href="route.route"
			v-for="(route, i) in routes"
			:key="route.key"
			class="text-sm text-neutral-800 dark:text-slate-200 font-medium"
			:class="i < routes.length - 1 ? 'hover:underline' : ''"
		>
			{{ route.label }}
			<OhVueIcon
				v-if="i < routes.length - 1"
				name="bi-chevron-right"
				scale="0.76"
			/>
		</component>
	</div>
</template>
