<script setup>
	defineProps({
		error: Boolean | null,
		title: String,
		subtitle: String | null,
	})
</script>

<template>
	<div
		:class="`
		px-6
		py-3
		rounded-xl
        ${error ? 'bg-rose-300' : 'bg-sky-200'}
    `"
	>
		<div class="font-semibold">{{ title }}</div>
		<div class="font-light">{{ subtitle }}</div>
	</div>
</template>
