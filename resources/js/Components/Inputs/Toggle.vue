<script setup>
	import { ref } from 'vue'
	import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

	const props = defineProps({
		modelValue: {
			type: Boolean,
		},
		label: {
			type: String,
		},
	})

	const emit = defineEmits(['update:modelValue'])
</script>
<template>
	<SwitchGroup
		as="div"
		class="flex items-center gap-3 text-neutral-500"
	>
		<Switch
			:modelValue="props.modelValue"
			:class="props.modelValue ? 'bg-sky-600' : 'bg-gray-200'"
			@update:modelValue="emit('update:modelValue', $event)"
			class="relative inline-flex h-6 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
		>
			<span
				aria-hidden="true"
				:class="props.modelValue ? 'translate-x-4' : 'translate-x-0'"
				class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
			/>
		</Switch>
		<SwitchLabel
			class="cursor-pointer flex items-center gap-1"
			:class="props.modelValue ? 'text-neutral-800 dark:text-slate-200' : ''"
		>
			<slot>
				{{ props.label }}
			</slot>
		</SwitchLabel>
	</SwitchGroup>
</template>
