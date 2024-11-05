<script setup>
	import { computed } from 'vue'

	const props = defineProps({
		label: String,
		onClick: Function,
		disabled: Boolean | null,
		outline: {
			type: [Boolean, null],
		},
		small: Boolean | null,
		autoWidth: {
			type: [Boolean, null],
		},
		fontLight: Boolean | null,
		circle: Boolean | null,
		bgClass: {
			type: [String, null],
			default: 'bg-sky-600 dark:bg-sky-800',
		},
		href: {
			type: String,
			default: null,
		},
		borderClass: {
			type: [String, null],
			default: 'border-sky-600 dark:border-sky-800',
		},
		textClass: {
			type: [String, null],
			default: 'text-white',
		},
		danger: Boolean,
	})

	const className = computed(() => {
		return `relative
    disabled:opacity-30
    disabled:cursor-not-allowed
    transition
    ${props.autoWidth ? 'w-auto' : 'w-full'}
    ${props.circle ? 'rounded-full' : 'rounded-lg'}
    ${props.outline ? 'bg-white dark:bg-slate-800' : props.bgClass ?? 'bg-sky-600 dark:bg-sky-800'}
    ${props.outline ? 'border-black dark:border-slate-400' : props.borderClass ?? 'border-sky-600 dark:border-sky-800'}
    ${props.outline ? 'text-black dark:text-slate-300' : props.textClass}
    ${props.outline ? 'hover:opacity-60' : 'hover:opacity-80'}
    ${props.small ? 'text-sm' : 'text-md'}
    ${props.small ? 'py-1' : 'py-3'}
    ${props.small ? 'font-light' : props.fontLight ? 'font-normal' : 'font-semibold'}
    ${props.small ? 'border' : 'border-2'}`
	})
</script>

<template>
	<component
		:is="href ? 'a' : 'button'"
		:href="href"
		:disabled="disabled"
		@click="onClick"
		:class="className"
	>
		<slot
			name="icon"
			v-if="$slots.icon"
		/>
		{{ label }}
	</component>
</template>
