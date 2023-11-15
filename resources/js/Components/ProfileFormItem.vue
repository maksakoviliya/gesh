<script setup>
	defineProps({
		disabled: Boolean,
		label: String,
		value: String | null,
	})

	const emit = defineEmits(['onToggle'])
</script>

<template>
	<div
		class="w-full flex justify-between items-baseline border-b border-neutral-200 pb-4"
		:class="`${disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : ''}`"
	>
		<div>
			<div>{{ label }}</div>
			<div
				class="text-neutral-500 font-light"
				v-if="!disabled"
			>
				{{ value }}
			</div>
			<div v-else></div>
		</div>
		<button
			type="button"
			@click="emit('onToggle')"
			class="text-xs text-neutral-700 font-semibold hover:text-neutral-800 underline"
		>
			{{ !disabled ? 'Редактировать' : 'Отменить' }}
		</button>
	</div>
</template>
