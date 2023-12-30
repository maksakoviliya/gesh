<script setup>
	import Heading from '@/Components/Heading.vue'
	import Modal from '@/Components/Modals/Modal.vue'
	import { ref } from 'vue'
	import { useForm, usePage } from '@inertiajs/vue3'
	import Input from '@/Components/Input.vue'
	import PhoneInput from '@/Components/PhoneInput.vue'
	import useToasts from '@/hooks/useToasts'

	const props = defineProps({
		instructor: {
			type: Object,
		},
	})

	const isOpen = ref(false)

	const handleClose = () => {
		isOpen.value = false
	}

	const page = usePage()
	const form = useForm({
		name: page.props.user?.data?.name,
		phone: page.props.user?.data?.phone,
	})
	const { successToast } = useToasts()
	const handleSubmit = async () => {
		await form.post(
			route('instructors.schedule', {
				instructor: props.instructor.id,
			}),
			{
				preserveScroll: true,
				onSuccess: () => {
					form.reset()
					isOpen.value = false
					successToast('Запись прошла успешно!')
				},
			}
		)
	}
</script>

<template>
	<div>
		<button
			type="button"
			@click="isOpen = true"
			class="mt-3 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
		>
			Записаться
		</button>

		<Modal
			:is-open="isOpen"
			@onSecondaryAction="handleClose"
			@onClose="handleClose"
			@onSubmit="handleSubmit"
			title="Запись"
			action-label="Записаться"
			secondary-action-label="Отменить"
		>
			<template #body>
				<Heading
					title="Запись к инструктору"
					subtitle="Заполните некоторые поля, чтобы попасть на занятие к инструктору."
				/>

				<div class="flex flex-col gap-3 mt-6">
					<Input
						v-model="form.name"
						name="name"
						:error="form.errors.name"
						label="Как вас зовут"
						id="name"
					/>
					<PhoneInput
						v-model="form.phone"
						name="phone"
						:error="form.errors.phone"
						label="Телефон"
						id="phone"
					/>
				</div>
			</template>
		</Modal>
	</div>
</template>
