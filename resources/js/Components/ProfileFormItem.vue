<script setup>
	import { ref } from 'vue'
	import Input from '@/Components/Input.vue'
	import { useForm } from '@inertiajs/vue3'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import useToasts from '@/hooks/useToasts'
	import PhoneInput from '@/Components/PhoneInput.vue'

	const props = defineProps({
		url: {
			type: String,
			required: true,
		},
		label: {
			type: String,
		},
		field: {
			type: String,
		},
		value: {
			type: [String, null],
		},
	})

	const active = ref(false)
	const toggleActive = () => {
		active.value = !active.value
	}

	const form = useForm({
		[props.field]: props.value,
	})

	const { successToast } = useToasts()
	const onSubmit = () => {
		form.post(props.url, {
			onSuccess() {
				successToast('Данные профиля успешно обновлены')
				toggleActive()
			},
			preserveScroll: true,
		})
	}
</script>

<template>
	<div class="border-b border-neutral-200 dark:border-slate-700 pb-4">
		<div class="w-full flex justify-between items-baseline">
			<div class="dark:text-slate-400">{{ label }}</div>
			<button
				type="button"
				@click="toggleActive"
				class="text-xs text-neutral-700 dark:text-slate-500 dark:hover:text-slate-400 font-semibold hover:text-neutral-800 underline"
			>
				{{ !active ? 'Редактировать' : 'Отменить' }}
			</button>
		</div>
		<div class="w-full">
			<div
				class="text-neutral-500 dark:text-slate-100 font-light"
				v-if="!active"
			>
				{{ value }}
			</div>
			<div
				v-else
				class="mt-3 flex items-center gap-3"
			>
				<Input
					v-if="props.field !== 'phone'"
					:label="label"
					:error="form.errors[props.field]"
					v-model="form[props.field]"
				/>
				<PhoneInput
					v-else
					:label="props.label"
					:error="form.errors[props.field]"
					v-model="form[props.field]"
				/>
				<ButtonComponent
					label="Сохранить"
					:auto-width="true"
					@click="onSubmit"
					class="px-3 py-5"
				/>
			</div>
		</div>
	</div>
</template>
