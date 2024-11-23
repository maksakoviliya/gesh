<script setup>
	import { Link } from '@inertiajs/vue3'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiPencilAlt } from 'oh-vue-icons/icons'

	addIcons(HiPencilAlt)

	defineProps({ id: String })
</script>

<template>
	<a
		target="_blank"
		:href="
			route('filament.admin.resources.apartments.edit', {
				record: id,
			})
		"
	>
		<OhVueIcon
			class="text-white hover:text-blue-500"
			name="hi-pencil-alt"
			scale="1.75"
		/>
	</a>
</template>
