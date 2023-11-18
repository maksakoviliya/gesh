<script setup>
	import { computed } from 'vue'

	const props = defineProps({
		label: String,
		onClick: Function,
		disabled: Boolean | null,
		outline: Boolean | null,
		small: Boolean | null,
		fontLight: Boolean | null,
		bgClass: {
			type: String,
			default: 'bg-sky-600',
		},
		borderClass: {
			type: String,
			default: 'border-sky-600',
		},
	})

	const className = computed(() => {
		return `relative
    disabled:opacity-30
    disabled:cursor-not-allowed
    rounded-lg
    transition
    w-full
    ${props.outline ? 'bg-white' : props.bgClass}
    ${props.outline ? 'border-black' : props.borderClass}
    ${props.outline ? 'text-black' : 'text-white'}
    ${props.outline ? 'hover:opacity-60' : 'hover:opacity-80'}
    ${props.small ? 'text-sm' : 'text-md'}
    ${props.small ? 'py-1' : 'py-3'}
    ${props.small ? 'font-light' : props.fontLight ? 'font-normal' : 'font-semibold'}
    ${props.small ? 'border-[1px]' : 'border-2'}`
	})
</script>

<template>
	<button
		:disabled="disabled"
		@click="onClick"
		:class="className"
	>
		<slot
			name="icon"
			v-if="$slots.icon"
		/>
		{{ label }}
	</button>
</template>
