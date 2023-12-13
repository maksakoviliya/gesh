<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { MdKingbedTwotone } from 'oh-vue-icons/icons'
	addIcons(MdKingbedTwotone)

	defineProps({
		beds: Number | String,
	})
</script>

<template>
	<div class="flex items-center gap-1 font-semibold text-sm dark:text-slate-200">
		<OhVueIcon
			name="md-kingbed-twotone"
			class="text-neutral-500 dark:text-slate-400"
		/>
		{{ beds ?? '-' }}
	</div>
</template>
