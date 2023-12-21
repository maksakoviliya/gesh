<script setup>
	import { Link, router } from '@inertiajs/vue3'
	import { computed } from 'vue'
	import Badge from '@/Components/Badge.vue'

	const props = defineProps({
		reservation: Object,
	})

	const subtitle = computed(() => {
		const result = [
			`${props.reservation.apartment.guests}&nbsp;гостей`,
			`${props.reservation.apartment.bedrooms}&nbsp;спальня`,
			`${props.reservation.apartment.beds}&nbsp;кровать`,
			`${props.reservation.apartment.bathrooms}&nbsp;ванная`,
		]
		return result.filter((item) => !!item).join(' · ')
	})

	const handleClickApartment = () => {
		router.visit(
			route('apartment', {
				apartment: props.reservation.apartment?.id,
			})
		)
	}

	const handleClickReservation = () => {
		router.visit(
			route('account.reservations.view', {
				reservation: props.reservation.id,
			})
		)
	}

	const badgeText = computed(() => {
		switch (props.reservation.status) {
			case 'pending':
				return 'Ожидает оплаты'
			case 'paid':
				return 'Оплачено'
			case 'first_payment':
				return 'Предоплата'
			default:
				return 'info'
		}
	})
	const badgeType = computed(() => {
		switch (props.reservation.status) {
			case 'pending':
				return 'warning'
			case 'paid':
				return 'success'
			case 'first_payment':
				return 'pending'
			default:
				return 'info'
		}
	})
</script>

<template>
	<div
		class="rounded-lg border cursor-pointer hover:shadow-lg hover:bg-gray-50 transition"
		@click="handleClickReservation"
	>
		<div
			class="p-4 flex items-stretch gap-2"
			@click="handleClickApartment"
		>
			<div class="h-24 w-32 rounded-lg overflow-hidden">
				<img
					:src="props.reservation.apartment?.media[0]?.src"
					class="h-full w-full object-cover"
					alt=""
				/>
			</div>
			<div class="flex flex-col justify-between">
				<div class="text-gray-600 font-light dark:text-slate-200">
					{{ props.reservation.apartment?.category?.title }}
				</div>
				<div
					class="font-light text-xs text-gray-600 mt-1 dark:text-slate-200"
					v-html="subtitle"
				></div>
			</div>
		</div>
		<dl class="divide-y border-t">
			<div class="py-2 px-4 flex w-full items-baseline justify-between text-sm">
				<dt class="font-light leading-6 text-gray-600">
					<div>Даты:</div>
				</dt>
				<dd class="mt-1 font-medium leading-6 text-neutral-600">
					с {{ props.reservation.start }} по {{ props.reservation.end }}
				</dd>
			</div>
			<div class="py-2 px-4 flex w-full items-baseline justify-between text-sm">
				<dt class="font-light leading-6 text-gray-600">
					<div>Ночи:</div>
				</dt>
				<dd class="mt-1 font-medium leading-6 text-neutral-600">{{ props.reservation.range }} ночи</dd>
			</div>
			<div class="py-2 px-4 flex w-full items-baseline justify-between text-sm">
				<dt class="font-light leading-6 text-gray-600 dark:text-slate-300">
					<div>Гости:</div>
				</dt>
				<dd class="mt-1 font-medium leading-6 text-neutral-600 dark:text-slate-400">
					{{ props.reservation.guests }} гостей
				</dd>
			</div>
			<div class="py-2 px-4 flex w-full items-baseline justify-between text-sm">
				<dt class="font-light leading-6 text-gray-600">
					<div>Дети:</div>
				</dt>
				<dd class="mt-1 font-medium leading-6 text-neutral-600">
					<template v-if="props.reservation.children"> {{ props.reservation.children }} детей </template>
					<template v-else> - </template>
				</dd>
			</div>
			<div class="py-2 px-4 flex w-full items-baseline justify-between text-sm">
				<dt class="font-light leading-6 text-gray-600">
					<div>Стоимость:</div>
				</dt>
				<dd class="mt-1 font-medium leading-6 text-neutral-600 flex items-center gap-2">
					{{ props.reservation.price.toLocaleString() }}₽
					<Badge
						:label="badgeText"
						:type="badgeType"
					/>
				</dd>
			</div>
		</dl>
	</div>
</template>
