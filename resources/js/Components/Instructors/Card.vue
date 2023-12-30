<script setup>
	import { Link } from '@inertiajs/vue3'

	defineProps({
		instructor: Object,
	})
</script>

<template>
	<div class="group">
		<!--		<Link href="#">-->
		<img
			:src="instructor.avatar.src"
			:srcset="instructor.avatar.srcset"
			:alt="instructor.name"
		/>
		<!--		</Link>-->
	</div>
</template>
