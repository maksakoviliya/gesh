<script setup>
	import { Link } from '@inertiajs/vue3'

	defineProps(['drive'])
</script>

<template>
	<Link
		:href="
			route('transfer.regular-ride.view', {
				drive: drive.id,
			})
		"
		class="relative h-40 md:h-40 overflow-hidden rounded-2xl cursor-pointer group"
	>
		<img
			class="absolute h-full w-full object-cover top-1/2 -translate-y-1/2 group-hover:scale-110 transition"
			:src="drive.img"
			:alt="drive.name"
		/>
		<div class="absolute inset-0 bg-neutral-800/60 group-hover:bg-neutral-800/50 transition"></div>

		<div class="absolute top-1/2 -translate-y-1/2 p-4 md:p-6">
			<div class="text-white dark:text-slate-200">
				<h2 class="text-2xl leading-none tracking-tight sm:text-3xl">{{ drive.name }}</h2>
				<p class="mt-2 text-lg leading-tight">от {{ drive.price }}</p>
			</div>
		</div>
	</Link>
</template>
