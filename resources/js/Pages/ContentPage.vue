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
		<Container xs>
			<Heading
				:title="props.title"
				class="mt-12"
			/>
			<div
				v-html="props.content"
				class="mt-10 text-neutral-800 dark:text-slate-300 leading-loose"
			></div>
		</Container>
	</AppLayout>
</template>
