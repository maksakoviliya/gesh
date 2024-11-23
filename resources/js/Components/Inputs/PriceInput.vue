<script setup>
	import Input from '@/Components/Input.vue'
	import { computed } from 'vue'

	const props = defineProps({
		id: String,
		label: String,
		error: String | null,
		disabled: Boolean | null,
		required: Boolean | null,
		modelValue: String | null,
	})

	const priceWithCommission = computed(() => {
		return Math.ceil(props.modelValue * 1.176)
	})
</script>

<template>
	<form
		class="w-full relative flex flex-col items-center"
		autocomplete="off"
	>
		<input
			:id="id"
			:disabled="disabled"
			placeholder=" "
			:value="modelValue"
			@input="$emit('update:modelValue', $event.target.value)"
			type="number"
			autocomplete="new-password"
			class="w-full p-4 pt-6 text-center text-[80px] font-bold bg-white dark:bg-slate-800 dark:text-slate-200 border-0 shadow-none outline-none transition disabled:opacity-70 focus:ring-0 disabled:cursor-not-allowed"
			:class="`
                    ${error ? 'border-rose-500' : ''}
                ${error ? 'focus:border-rose-500' : ''}
            `"
		/>

		<label
			class="block w-full text-m font-semibold"
			:class="error ? 'text-rose-500' : 'text-neutral-800 dark:text-slate-400'"
		>
			₽ / ночь
			<span
				class="font-light"
				:class="error ? 'text-rose-500' : 'text-zinc-400 dark:text-zinc-300'"
				>{{ label
				}}<sup
					v-if="required"
					class="text-sm text-rose-400"
					>*</sup
				></span
			>
		</label>
		<span class="text-sm text-zinc-500 dark:text-zinc-300"
			>Для гостя: <span class="text-lg font-medium">{{ priceWithCommission }}₽</span>
		</span>
		<div
			v-if="!!error"
			class="text-rose-500 text-sm font-light"
		>
			{{ error }}
		</div>
	</form>
</template>

<style>
	/* Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Firefox */
	input[type='number'] {
		-moz-appearance: textfield;
	}
</style>
