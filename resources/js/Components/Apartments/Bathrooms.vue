<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { MdBathtubOutlined } from 'oh-vue-icons/icons'

	addIcons(MdBathtubOutlined)

	defineProps({
		bathrooms: Number | String,
	})
</script>

<template>
	<div class="flex items-center gap-1 font-semibold text-sm">
		<OhVueIcon
			name="md-bathtub-outlined"
			class="text-neutral-500"
		/>
		{{ bathrooms ?? '-' }}
	</div>
</template>
