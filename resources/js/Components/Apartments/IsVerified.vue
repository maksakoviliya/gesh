<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { MdVerifiedSharp } from 'oh-vue-icons/icons'

	addIcons(MdVerifiedSharp)
</script>

<template>
	<div class="absolute top-0 right-0 z-20 text-blue-500">
		<OhVueIcon
			name="md-verified-sharp"
			scale="1.75"
		/>
	</div>
</template>
