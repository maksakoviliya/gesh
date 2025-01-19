<script setup>
	import { onMounted, watch } from 'vue'
	import { useIMask } from 'vue-imask'

	const props = defineProps({
		id: String,
		label: String,
		type: String | null,
		error: String | null,
		disabled: Boolean | null,
		required: Boolean | null,
		modelValue: String,
		mask: String | null,
	})

	const { el, masked } = useIMask({
		mask: '+{7} (000) 000-00-00',
	})

	const emit = defineEmits(['update:modelValue'])
	watch(masked, (value) => {
		emit('update:modelValue', value)
	})

	onMounted(() => {
		masked.value = props.modelValue ?? ''
	})
</script>

<template>
	<div class="w-full relative">
		<input
			:id="id"
			ref="el"
			:disabled="disabled"
			placeholder=" "
			:type="type"
			:name="id"
			autocomplete="new-password"
			class="peer w-full p-4 pt-6 font-light bg-white dark:bg-slate-800 dark:text-slate-300 border-2 rounded-md shadow-none outline-none transition disabled:opacity-70 focus:ring-0 pl-4 disabled:cursor-not-allowed"
			:class="`
                    ${error ? 'border-rose-500' : 'border-neutral-300 dark:border-slate-400'}
                ${error ? 'focus:border-rose-500' : 'focus:border-black dark:focus:border-slate-300'}
            `"
		/>
		<label
			class="absolute text-md duration-150 transform -translate-y-3 scale-75 top-5 left-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4"
			:class="error ? 'text-rose-500' : 'text-zinc-400 dark:text-slate-400'"
		>
			{{ label
			}}<sup
				v-if="required"
				class="text-sm text-rose-400"
				>*</sup
			>
		</label>
		<div
			v-if="!!error"
			class="text-rose-500 text-sm font-light"
		>
			{{ error }}
		</div>
	</div>
</template>
