<script setup>
	import { usePage } from '@inertiajs/vue3'
	import { computed } from 'vue'
	import RegularDriveItem from '@/Components/Transfer/RegularDrive/RegularDriveItem.vue'

	const page = usePage()

	const regularDrives = computed(() => {
		return page.props.regularDrives ?? []
	})
</script>

<template>
	<div
		v-if="regularDrives.length"
		class="grid grid-cols-1 md:grid-cols-2 gap-4"
	>
		<RegularDriveItem
			class="mt-6"
			v-for="drive in regularDrives"
			:key="drive.id"
			:drive="drive"
		/>
	</div>
</template>
