<script setup>
	import Heading from '@/Components/Heading.vue'

	const props = defineProps({
		srcset: {
			type: String,
		},
		src: {
			type: String,
		},
		alt: {
			type: String,
		},
		title: {
			type: String,
		},
		subtitle: {
			type: String,
		},
	})
</script>

<template>
	<div class="relative h-36 md:h-48 overflow-hidden rounded-2xl">
		<img
			class="absolute top-1/2 -translate-y-1/2"
			:srcset="props.srcset"
			:src="props.src"
			:alt="props.alt"
		/>
		<div class="absolute inset-0 bg-neutral-800/60 group-hover:bg-neutral-800/50 transition"></div>

		<div class="absolute top-1/2 -translate-y-1/2 p-4 md:p-6">
			<div class="text-white dark:text-slate-200">
				<h2 class="text-3xl font-bold tracking-tight sm:text-4xl">{{ props.title }}</h2>
				<p class="mt-2 text-lg leading-tight">
					{{ props.subtitle }}
				</p>
			</div>
		</div>
	</div>
</template>
