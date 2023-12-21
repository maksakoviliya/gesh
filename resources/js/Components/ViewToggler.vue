<script setup>
	import { Link } from '@inertiajs/vue3'

	defineProps({
		to: String,
	})
</script>
<template>
	<Link
		:href="to"
		class="fixed left-1/2 -translate-x-1/2 bg-white dark:bg-slate-700 dark:text-slate-200 rounded-full px-4 py-2 bottom-40 sm:bottom-32 md:bottom-20 shadow-lg hover:scale-110 transition z-20"
	>
		<slot></slot>
	</Link>
</template>
