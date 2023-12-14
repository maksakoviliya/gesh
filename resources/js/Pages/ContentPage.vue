<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Heading from '@/Components/Heading.vue'

	const props = defineProps({
		content: {
			type: [Object, Array, null],
		},
		title: {
			type: [String, null],
			default: 'Название',
		},
	})
</script>

<template>
	<AppLayout>
		<Container>
			<Heading
				:title="props.title"
				class="mt-12"
			/>
			<div
				v-html="props.content"
				class="mt-10 mx-auto max-w-2xl text-neutral-800 dark:text-slate-300 text-justify"
			></div>
		</Container>
	</AppLayout>
</template>
