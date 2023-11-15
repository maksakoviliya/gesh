<script setup>
	defineProps({
		sm: Boolean | null,
	})
</script>

<template>
	<div :class="`mx-auto md:px-10 sm:px-2 px-4 ${sm ? 'xl:px-36 max-w-[1520px]' : 'xl:px-20 max-w-[2520px]'}`">
		<slot></slot>
	</div>
</template>
