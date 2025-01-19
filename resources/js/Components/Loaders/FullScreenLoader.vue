<script setup>
	import Spinner from '@/Components/Loaders/Spinner.vue'

	defineProps({
		loading: Boolean,
	})
</script>
<template>
	<div
		class="flex items-center justify-center fixed inset-0 z-20 bg-gray-50/80 dark:bg-gray-800/80"
		v-if="loading"
	>
		<Spinner />
	</div>
</template>
