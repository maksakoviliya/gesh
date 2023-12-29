<script setup>
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Modal from '@/Components/Modals/Modal.vue'
	import { computed, ref } from 'vue'
	import Input from '@/Components/Input.vue'
	import { router, useForm } from '@inertiajs/vue3'
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
	const isOpenModalSubmit = ref(false)

	const form = useForm({
		status_text: '',
	})

	const { infoToast, successToast, errorToast } = useToasts()

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
	const handleSubmit = () => {
		axios
			.post(
				route('account.reservation-requests.submit', {
					reservationRequest: request.value.id,
				})
			)
			.then((res) => {
				isOpenModalSubmit.value = false
				request.value.status = res.data?.status
				request.value.reservation_id = res.data?.reservation_id
				successToast('Создано новое бронирование. Ожидайте оплату.')
			})
			.catch((error) => {
				errorToast('Что-то пошло не так.')
			})
	}

	const goToReservation = () => {
		if (request.value.reservation?.id) {
			const url = props.isOwner ? 'account.reservations.owner.view' : 'account.reservations.view'
			router.visit(
				route(url, {
					reservation: request.value.reservation?.id,
				})
			)
		}
	}

	const servicePrice = computed(() => {
		return Math.ceil(request.value.price * 0.18)
	})

	const totalPrice = computed(() => {
		return request.value.price + servicePrice.value
	})
</script>

<template>
	<div
		class="border border-gray-300 dark:border-slate-700 rounded-lg p-3"
		:class="[
			request.status === 'rejected' ? 'opacity-40' : '',
			request.status === 'submitted' ? 'border-teal-600' : '',
		]"
	>
		<div
			class="flex items-baseline justify-between"
			:class="props.compact ? 'flex-col-reverse gap-0' : 'gap-4'"
		>
			<div class="font-semibold text-neutral-800 dark:text-slate-200">Запрос на бронирование</div>
			<div class="font-light text-xs text-gray-400">{{ request.created_at }}</div>
		</div>
		<div class="font-light text-neutral-800 dark:text-white">
			с {{ request.start }} по {{ request.end }} |
			<span class="text-neutral-400 text-sm">ночи: {{ request.range }}</span>
		</div>
		<div class="font-light text-neutral-800 dark:text-slate-200">
			Взрослые: {{ request.guests }}
			<span v-if="request.children > 0"> | Дети: {{ request.children }}</span>
		</div>
		<div class="flex items-center gap-2">
			<div class="font-light text-neutral-800 dark:text-slate-200">
				Цена: {{ request.price.toLocaleString() }}₽
			</div>
			|
			<div class="font-light text-neutral-800 dark:text-slate-200">
				Сервисный сбор: {{ servicePrice.toLocaleString() }}₽
			</div>
		</div>
		<div class="font-light text-neutral-800 dark:text-slate-200">Итого: {{ totalPrice.toLocaleString() }}₽</div>

		<template v-if="!props.compact">
			<div class="flex justify-end gap-2 mt-3">
				<template v-if="props.isOwner">
					<template v-if="request.status === 'pending'">
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
							@click="isOpenModalSubmit = true"
							:small="true"
							bg-class="bg-green-50"
							text-class="text-green-800"
							border-class="border-green-800"
							:auto-width="true"
							class="px-3"
						/>
					</template>
				</template>
				<template v-if="request.status === 'submitted' && request.reservation?.id">
					<ButtonComponent
						label="К бронированию"
						:small="true"
						:outline="true"
						:auto-width="true"
						@click="goToReservation"
						class="px-3"
					/>
				</template>
			</div>
		</template>
		<div
			class="font-light text-neutral-800"
			v-if="request.status === 'rejected'"
		>
			{{ `Отказано${request.status_text ? ': ' + request.status_text : ''}` }}
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
					label="Укажите причину отказа (можно не указывать)"
				/>
			</template>
		</Modal>

		<Modal
			:is-open="isOpenModalSubmit"
			@onSecondaryAction="isOpenModalSubmit = false"
			@onClose="isOpenModalSubmit = false"
			@onSubmit="handleSubmit"
			title="Подтвердить запрос на бронирование"
			action-label="Подтвердить"
			secondary-action-label="Отменить"
		>
			<template #body>
				<dl class="divide-y divide-gray-100">
					<div class="py-2 flex w-full items-baseline justify-between">
						<dt class="font-light leading-6 text-пкфн-600">
							<div>Даты:</div>
						</dt>
						<dd class="mt-1 font-medium leading-6 text-neutral-600">
							с {{ request.start }} по {{ request.end }} |
							<span class="text-neutral-400 text-sm">ночи: {{ request.range }}</span>
						</dd>
					</div>
					<div class="py-2 flex w-full items-baseline justify-between">
						<dt class="font-light leading-6 text-пкфн-600">
							<div>Взрослые:</div>
						</dt>
						<dd class="mt-1 font-medium leading-6 text-neutral-600">
							{{ request.guests }}
						</dd>
					</div>
					<div
						class="py-2 flex w-full items-baseline justify-between"
						v-if="request.children > 0"
					>
						<dt class="font-light leading-6 text-пкфн-600">
							<div>Дети:</div>
						</dt>
						<dd class="mt-1 font-medium leading-6 text-neutral-600">
							{{ request.children }}
						</dd>
					</div>
					<div class="py-2 flex w-full items-baseline justify-between">
						<dt class="font-light leading-6 text-пкфн-600">
							<div>{{ request.range }} ночи:</div>
						</dt>
						<dd class="mt-1 font-medium leading-6 text-neutral-600">
							{{ request.price.toLocaleString() }}₽
						</dd>
					</div>
					<div class="py-2 flex w-full items-baseline justify-between">
						<dt class="font-light leading-6 text-пкфн-600">
							<div>Сервисный сбор:</div>
						</dt>
						<dd class="mt-1 font-medium leading-6 text-neutral-600">
							{{ servicePrice.toLocaleString() }}₽
						</dd>
					</div>
					<div class="py-2 flex w-full items-baseline justify-between">
						<dt class="font-bold leading-6 text-neutral-800">
							<div>Итого:</div>
						</dt>
						<dd class="mt-1 font-bold leading-6 text-neutral-800">{{ totalPrice.toLocaleString() }}₽</dd>
					</div>
				</dl>
			</template>
		</Modal>
	</div>
</template>
