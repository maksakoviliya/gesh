<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiSolidMinusSm, HiSolidPlusSm } from 'oh-vue-icons/icons'

	addIcons(HiSolidMinusSm, HiSolidPlusSm)

	const props = defineProps({
		title: String,
		subtitle: String,
		modelValue: Number,
		error: String | null,
	})

	const emit = defineEmits(['update:modelValue'])

	const onReduce = () => {
		if (props.modelValue < 1) {
			return
		}
		emit('update:modelValue', props.modelValue - 1)
	}
	const onAdd = () => {
		if (props.modelValue > 19) {
			return
		}
		emit('update:modelValue', props.modelValue + 1)
	}
</script>

<template>
	<div>
		<div class="flex flex-row items-center justify-between">
			<div class="flex flex-col">
				<div
					class="font-medium"
					:class="props.error ? 'text-rose-400' : 'text-neutral-600'"
				>
					{{ title }}
				</div>
				<div
					class="font-light"
					:class="props.error ? 'text-rose-400' : 'text-gray-600'"
				>
					{{ subtitle }}
				</div>
			</div>
			<div class="flex flex-row items-center gap-4">
				<div
					@click="onReduce"
					class="w-10 h-10 rounded-full border-[1px] border-neutral-400 flex items-center justify-center cursor-pointer hover:opacity-80 transition"
				>
					<OhVueIcon name="hi-solid-minus-sm" />
				</div>
				<div
					class="font-light text-xl"
					:class="props.error ? 'text-rose-400' : 'text-neutral-600'"
				>
					{{ modelValue }}
				</div>
				<div
					@click="onAdd"
					class="w-10 h-10 rounded-full border-[1px] border-neutral-400 flex items-center justify-center text-neutral-600 cursor-pointer hover:opacity-80 transition"
				>
					<OhVueIcon name="hi-solid-plus-sm" />
				</div>
			</div>
		</div>
		<div
			v-if="props.error"
			class="text-rose-500 text-sm font-light"
		>
			{{ props.error }}
		</div>
	</div>
</template>
