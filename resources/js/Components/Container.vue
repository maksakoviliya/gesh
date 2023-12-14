<script setup>
	import { computed } from 'vue'

	const props = defineProps({
		sm: {
			type: [Boolean, null],
		},
		xs: {
			type: [Boolean, null],
		},
	})

	const widthClass = computed(() => {
		if (props.xs) {
			return 'xl:px-36 max-w-5xl'
		}
		if (props.sm) {
			return 'xl:px-36 max-w-[1520px]'
		}
		return 'xl:px-20 max-w-[2520px]'
	})
</script>

<template>
	<div :class="`mx-auto md:px-10 sm:px-2 px-4 ${widthClass}`">
		<slot></slot>
	</div>
</template>
