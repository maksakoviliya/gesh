<script setup>
	import { Link } from '@inertiajs/vue3'

	const props = defineProps({
		href: {
			type: String,
		},
		srcset: {
			type: String,
		},
		src: {
			type: String,
		},
		alt: {
			type: String,
		},
	})
</script>

<template>
	<Link
		:href="props.href"
		class="block h-32 md:h-44 relative overflow-hidden rounded-lg group"
	>
		<img
			class="absolute inset-0 object-cover object-center w-full top-1/2 -translate-y-1/2 group-hover:scale-110 transition"
			sizes="(max-width: 960px) 100vw, 960px"
			:srcset="props.srcset"
			:src="props.src"
			:alt="props.alt"
		/>
		<div class="absolute inset-0 bg-neutral-800/60 group-hover:bg-neutral-800/50 transition"></div>
		<div
			class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 font-extrabold uppercase text-white dark:text-slate-200"
		>
			<slot />
		</div>
	</Link>
</template>
