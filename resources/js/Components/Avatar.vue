<script setup>
	const props = defineProps({
		src: {
			type: String,
		},
		square: {
			type: Boolean,
			default: false,
		},
	})
</script>

<template>
	<img
		class="w-[30px] h-[30px]"
		:class="props.square ? 'rounded' : 'rounded-full'"
		alt="Avatar"
		:src="props.src ?? '/img/no-user.svg'"
	/>
</template>
