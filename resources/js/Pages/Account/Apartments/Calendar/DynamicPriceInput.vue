<template>
	<Input
		:model-value="price"
		@update:modelValue="handleUpdate"
		type="number"
		:id="props.id"
		:error="props.error"
		:label="props.label"
	/>
	<span class="text-sm text-zinc-500 dark:text-zinc-300"
		>Для гостя: <span class="text-lg font-medium">{{ priceForGuest }}₽</span>
	</span>
</template>

<script setup>
	import Input from '@/Components/Input.vue'
	import { ref } from 'vue'

	const props = defineProps({
		modelValue: {
			required: true,
		},
		error: {
			required: false,
		},
		id: {
			type: String,
			required: false,
		},
		label: {
			type: String,
			required: true,
		},
	})

	const price = ref(props.modelValue)
	const priceForGuest = ref(props.modelValue)

	const emit = defineEmits(['update:modelValue'])

	const handleUpdate = (val) => {
		priceForGuest.value = Math.ceil(val * 1.15)
		emit('update:modelValue', priceForGuest.value)
	}
</script>
