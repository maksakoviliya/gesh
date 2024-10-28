<script setup>
	import { Link } from '@inertiajs/vue3'

	defineProps(['price'])
</script>

<template>
	<div class="text-neutral-400 dark:text-slate-400">
		от
		<span class="font-bold text-xl text-neutral-800 dark:text-white">
			{{ new Intl.NumberFormat().format(price) }}</span
		>
		₽ / ночь
	</div>
</template>
