<script setup>
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Modal from '@/Components/Modals/Modal.vue'
	import { ref } from 'vue'
	import Input from '@/Components/Input.vue'
	import { useForm } from '@inertiajs/vue3'
	import useToasts from '@/hooks/useToasts'

	const props = defineProps({
		item: {
			required: true,
		},
		compact: {
			type: Boolean,
			default: false,
		},
		isOwner: {
			type: Boolean,
			default: false,
		},
	})

	const request = ref(props.item)

	const isOpenModalReject = ref(false)
	const isOpenModalConfirm = ref(false)

	const form = useForm({
		status_text: '',
	})

	const { infoToast } = useToasts()

	const handleReject = () => {
		axios
			.post(
				route('account.reservation-requests.reject', {
					reservationRequest: request.value.id,
				}),
				{
					status_text: form.status_text,
				}
			)
			.then((res) => {
				isOpenModalReject.value = false
				request.value.status = res.data?.status
				request.value.status_text = res.data?.status_text
				infoToast('Отказано в запросе на бронирование.')
			})
			.catch((error) => {
				if (error.response?.status === 422) {
					console.log('error.response?.data?.message', error.response?.data?.message)
					form.setError('status_text', error.response?.data?.message ?? 'Что-то пошло не так.')
				}
			})
	}
	const handleConfirm = () => {
		console.log('handleConfirm')
	}
</script>

<template>
	<div
		class="border border-gray-300 rounded-lg p-3"
		:class="request.status === 'rejected' ? 'opacity-40' : ''"
	>
		<div
			class="flex items-baseline justify-between"
			:class="props.compact ? 'flex-col-reverse gap-0' : 'gap-4'"
		>
			<div class="font-semibold text-neutral-800">Запрос на бронирование</div>
			<div class="font-light text-xs text-gray-400">{{ request.created_at }}</div>
		</div>
		<div class="font-light text-neutral-800">
			с {{ request.start }} по {{ request.end }} |
			<span class="text-neutral-400 text-sm">ночи: {{ request.range }}</span>
		</div>
		<div class="font-light text-neutral-800">
			Взрослые {{ request.range }}
			<span v-if="request.children > 0"> | Дети {{ request.children }}</span>
		</div>
		<div v-if="!props.compact">
			<div
				v-if="props.isOwner && request.status !== 'rejected'"
				class="flex justify-end gap-2"
			>
				<ButtonComponent
					label="Отказать"
					@click="isOpenModalReject = true"
					:small="true"
					:outline="true"
					:auto-width="true"
					class="px-3"
				/>
				<ButtonComponent
					label="Подтвердить"
					@click="isOpenModalConfirm = true"
					:small="true"
					bg-class="bg-green-50"
					text-class="text-green-800"
					border-class="border-green-800"
					:auto-width="true"
					class="px-3"
				/>
			</div>
		</div>
		<div
			class="font-light text-neutral-800"
			v-if="request.status === 'rejected'"
		>
			{{ `Отменен${request.status_text ? ': ' + request.status_text : ''}` }}
		</div>

		<Modal
			:is-open="isOpenModalReject"
			@onSecondaryAction="isOpenModalReject = false"
			@onClose="isOpenModalReject = false"
			@onSubmit="handleReject"
			title="Отказать в запросе на бронирование"
			action-label="Отказать"
			secondary-action-label="Отменить"
		>
			<template #body>
				<Input
					v-model="form.status_text"
					id="reason"
					name="reason"
					:error="form.errors.status_text"
					label="Укажите причину отказа (можно остваить пустым)"
				/>
			</template>
		</Modal>

		<Modal
			:is-open="isOpenModalConfirm"
			@onSecondaryAction="isOpenModalConfirm = false"
			@onClose="isOpenModalConfirm = false"
			@onSubmit="handleConfirm"
			title="Подтвердить запрос на бронирование"
			action-label="Подтвердить"
			secondary-action-label="Отменить"
		>
			<template #body> фыв</template>
		</Modal>
	</div>
</template>
