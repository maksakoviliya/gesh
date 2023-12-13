<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiUsers } from 'oh-vue-icons/icons'

	addIcons(HiUsers)

	defineProps({
		guests: Number | String,
	})
</script>

<template>
	<div class="flex items-center gap-1 font-semibold text-sm dark:text-slate-200">
		<OhVueIcon
			name="hi-users"
			class="text-neutral-500 dark:text-slate-400"
		/>
		{{ guests ?? '-' }}
	</div>
</template>
