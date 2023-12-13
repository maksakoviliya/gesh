<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { MdMeetingroomOutlined } from 'oh-vue-icons/icons'
	addIcons(MdMeetingroomOutlined)

	defineProps({
		bedrooms: Number | String,
	})
</script>

<template>
	<div class="flex items-center gap-1 font-semibold text-sm dark:text-slate-200">
		<OhVueIcon
			name="md-meetingroom-outlined"
			class="text-neutral-500 dark:text-slate-400"
		/>
		{{ bedrooms ?? '-' }}
	</div>
</template>
