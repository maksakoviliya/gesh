<script setup>
	import { Link } from '@inertiajs/vue3'
</script>

<template>
	<Link
		:href="route('home')"
		class="hidden md:block"
	>
		<img
			src="/img/logo.png"
			class="h-8"
			alt=""
		/>
	</Link>
</template>
