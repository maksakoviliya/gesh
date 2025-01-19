<script setup>
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Modal from '@/Components/Modals/Modal.vue'
	import { computed, ref } from 'vue'
	import { useForm, usePage } from '@inertiajs/vue3'
	import Input from '@/Components/Input.vue'
	import useToasts from '@/hooks/useToasts'
	import PhoneInput from '@/Components/PhoneInput.vue'

	const props = defineProps({
		apartmentId: {
			type: String,
			required: true,
		},
	})

	const isOpen = ref(false)

	const handleClose = () => {
		isOpen.value = false
	}

	const page = usePage()

	const user = computed(() => page.props.auth.user)

	const handleContact = () => {
		if (user.value?.id && user.value?.name && user.value?.phone) {
			handleSubmit()
		} else {
			isOpen.value = true
		}
	}

	const form = useForm({
		user_id: user.value?.id ?? null,
		apartment_id: props.apartmentId ?? null,
		name: user.value?.name ?? null,
		phone: user.value?.phone ?? null,
		telegram_username: user.value?.telegram_username ? `@${user.value?.telegram_username}` : null,
	})

	const { successToast } = useToasts()

	const handleSubmit = () => {
		form.post(route('contact-request.store'), {
			preserveScroll: true,
			onSuccess: () => {
				handleClose()
				successToast('С вами свяжутся в ближайшее время!')
			},
		})
	}
</script>

<template>
	<div>
		<ButtonComponent @click="handleContact">Связаться с собственником</ButtonComponent>
		<Modal
			:is-open="isOpen"
			@onSecondaryAction="handleClose"
			@onClose="handleClose"
			@onSubmit="handleSubmit"
			title="Связаться с обственником"
			action-label="Отправить"
			secondary-action-label="Отменить"
		>
			<template #body>
				<div class="flex flex-col gap-3">
					<Input
						id="name"
						:required="true"
						type="text"
						v-model="form.name"
						:error="form.errors.name"
						label="Ваше имя"
					/>
					<PhoneInput
						id="phone"
						type="text"
						v-model="form.phone"
						:error="form.errors.phone"
						label="Ваш телефон"
						:required="true"
					/>
					<div class="text-center text-neutral-400 dark:text-slate-400">- или -</div>
					<Input
						id="telegram_username"
						type="text"
						v-model="form.telegram_username"
						:error="form.errors.telegram_username"
						label="Ваш телеграм"
					/>
				</div>
			</template>
		</Modal>
	</div>
</template>
