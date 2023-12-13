<script setup>
	import ButtonComponent from '@/Components/ButtonComponent.vue'

	defineProps({
		center: Boolean,
		title: String,
		subtitle: String,
	})
</script>

<template>
	<div :class="center ? 'text-center' : 'text-start'">
		<h2 class="text-3xl font-bold tracking-tight text-neutral-800 dark:text-slate-100 sm:text-4xl">{{ title }}</h2>
		<p class="mt-2 text-lg leading-8 text-neutral-600 dark:text-slate-400">
			{{ subtitle }}
		</p>
	</div>
</template>
