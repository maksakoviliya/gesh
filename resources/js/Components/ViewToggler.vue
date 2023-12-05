<script setup>
	import { Link } from '@inertiajs/vue3'

	defineProps({
		to: String,
	})
</script>
<template>
	<Link
		:href="to"
		class="fixed left-1/2 -translate-x-1/2 bg-white rounded-full px-4 py-2 bottom-8 shadow-lg hover:scale-110 transition"
	>
		<slot></slot>
	</Link>
</template>
