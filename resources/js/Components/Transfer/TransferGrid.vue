<script setup>
	import Container from '@/Components/Container.vue'
	import RegularDrivesGrid from '@/Components/Transfer/RegularDrive/RegularDrivesGrid.vue'
	import Input from '@/Components/Input.vue'
</script>

<template>
	<Container xs>
		<div class="text-2xl md:text-4xl font-semibold text-neutral-800 dark:text-white">Забронировать поездку</div>
		<RegularDrivesGrid />
	</Container>
</template>
