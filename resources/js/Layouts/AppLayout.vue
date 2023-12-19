<script setup>
	import { Head } from '@inertiajs/vue3'
	import Navbar from '@/Components/Navbar.vue'
	import Footer from '@/Components/Footer.vue'
	import SpeedDial from '@/Components/SpeedDial.vue'

	const props = defineProps({
		title: {
			type: String,
		},
		hiddenSpeedDial: {
			type: [Boolean, null],
			default: false,
		},
		hiddenFooter: {
			type: [Boolean, null],
			default: false,
		},
	})
</script>

<template>
	<div class="min-h-screen pb-32 relative">
		<Head :title="title" />

		<Navbar />

		<main class="pt-24">
			<slot />
		</main>

		<Footer v-if="!props.hiddenFooter" />
	</div>
</template>
