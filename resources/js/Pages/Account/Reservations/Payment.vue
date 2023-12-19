<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Heading from '@/Components/Heading.vue'
	import { Link, router } from '@inertiajs/vue3'
	import { computed, ref } from 'vue'
	import dayjs from 'dayjs'
	import customParseFormat from 'dayjs/plugin/customParseFormat'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import Popover from '@/Components/Interactive/Popover.vue'

	const props = defineProps({
		reservation: {
			type: Object,
		},
	})

	const details = ref([])

	const basePrice = computed(() => {
		dayjs.extend(customParseFormat)
		const start = dayjs(props.reservation.data.start, 'DD.MM.YYYY')
		const end = dayjs(props.reservation.data.end, 'DD.MM.YYYY')
		details.value = []
		let sum = 0
		for (let date = start; date.isBefore(end); date = date.add(1, 'day')) {
			const price =
				date.day() === 5 || date.day() === 6
					? props.reservation.data.apartment.weekends_price
					: props.reservation.data.apartment.weekdays_price
			const customPrice = props.reservation.data.apartment.dates.find((item) => {
				const customDate = dayjs(item.date)
				return customDate.isSame(date)
			})?.price
			const totalPrice = customPrice ?? price
			details.value.push({
				date: date.format('DD.MM.YYYY'),
				price: totalPrice,
			})
			sum += totalPrice
		}
		return sum
	})

	const detalizationText = computed(() => {
		let nights = null
		if (props.reservation.data.range <= 1 || props.reservation.data.range === 21) {
			nights = `${props.reservation.data.range} ночь`
		}
		if (
			(props.reservation.data.range > 1 && props.reservation.data.range <= 5) ||
			(props.reservation.data.range > 21 && props.reservation.data.range <= 24)
		) {
			nights = `${props.reservation.data.range} ночи`
		}
		if (
			(props.reservation.data.range > 5 && props.reservation.data.range <= 20) ||
			props.reservation.data.range > 24
		) {
			nights = `${props.reservation.data.range} ночей`
		}
		return `${nights}`
	})

	const subtitle = computed(() => {
		const result = [
			`${props.reservation.data.apartment.guests}&nbsp;гостей`,
			`${props.reservation.data.apartment.bedrooms}&nbsp;спальня`,
			`${props.reservation.data.apartment.beds}&nbsp;кровать`,
			`${props.reservation.data.apartment.bathrooms}&nbsp;ванная`,
		]
		return result.filter((item) => !!item).join(' · ')
	})

	const redirectToPayPage = () => {
		router.visit(
			route('account.reservations.pay', {
				reservation: props.reservation.data.id,
			})
		)
	}

	const routes = ref([
		{
			id: 'account',
			route: route('account.index'),
			label: 'Аккаунт',
		},
		{
			id: 'reservations',
			route: route('account.reservations.list'),
			label: 'Мои бронирования',
		},
		{
			id: 'reservation',
			route: route('account.reservations.view', {
				reservation: props.reservation.data?.id,
			}),
			label: 'Бронирование',
		},
		{
			id: 'reservation.pay',
			route: route('account.reservations.view', {
				reservation: props.reservation.data?.id,
			}),
			label: 'Оплата',
		},
	])

	const servicePrice = computed(() => {
		return Math.ceil(basePrice.value * 0.18)
	})

	const totalPrice = computed(() => {
		return basePrice.value + servicePrice.value
	})

	const firstPayment = computed(() => {
		return Math.ceil(totalPrice.value * 0.3)
	})
</script>

<template>
	<AppLayout>
		<Container>
			<Breadcrumbs :routes="routes" />
			<div class="relative flex-col md:flex-row flex items-start gap-4 mt-6">
				<div class="md:w-1/2 lg:w-2/3">
					<Heading
						title="Оплата бронирования"
						subtitle="Вы должны оплатить не позднее суток, иначе бронирование отменится."
					/>

					<div>
						<div class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100">Ваша поездка:</div>
						<div class="mt-3">
							<div class="text-sm font-medium">Даты:</div>
							<div class="font-light">
								{{ props.reservation.data.start }} -
								{{ props.reservation.data.end }}
							</div>
						</div>
						<div class="mt-3">
							<div class="text-sm font-medium">Гости:</div>
							<div class="font-light">{{ props.reservation.data.guests }} гостя</div>
							<div
								class="font-light"
								v-if="props.reservation.data.children"
							>
								{{ props.reservation.data.children }} детей
							</div>
						</div>
					</div>
					<div>
						<div class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100">Оплата:</div>
						<ButtonComponent
							class="mt-3 px-16"
							:auto-width="true"
							:label="`Перейти к оплате: ${firstPayment.toLocaleString()}₽`"
							@click="redirectToPayPage"
						/>
						<div class="font-light text-sm text-neutral-800 leading-tight mt-2">
							Сейчас вам необходимо оплатить только 30% от общей суммы, чтобы забронировать жилье.
							Оставшуюся сумму вы сможете перевести хозяину при заселении в жилье. Таким образом, вы
							можете забронировать жилье заранее и не переживать о полной оплате до момента заселения.
							Оплата оставшейся суммы при заселении гарантирует вам получение жилья и удобство в расчетах.
						</div>
					</div>
				</div>
				<div
					class="md:sticky w-full md:w-1/2 lg:w-1/3 rounded-lg shadow-lg border border-neutral-100 top-28 p-6"
				>
					<div class="flex items-stretch justify-start gap-4">
						<Link
							:href="
								route('apartment', {
									apartment: props.reservation.data.apartment?.id,
								})
							"
							class="h-24 w-32 rounded-lg overflow-hidden"
						>
							<img
								:src="props.reservation.data.apartment?.media[0]?.src"
								class="h-full w-full object-cover"
								alt=""
							/>
						</Link>
						<div class="flex flex-col justify-between">
							<div class="text-gray-600 font-light">
								{{ props.reservation.data?.apartment?.category?.title }}
							</div>
							<div
								class="font-light text-xs text-gray-600 mt-1"
								v-html="subtitle"
							></div>
						</div>
					</div>
					<div class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100">Детализация цены:</div>
					<dl class="divide-y divide-gray-100">
						<div class="py-2 flex w-full items-baseline justify-between">
							<dt class="font-light leading-6 text-пкфн-600">
								<div>Гости:</div>
							</dt>
							<dd class="mt-1 font-medium leading-6 text-neutral-600">
								{{ props.reservation.data.guests }}
							</dd>
						</div>
						<div
							class="py-2 flex w-full items-baseline justify-between"
							v-if="props.reservation.data.children > 0"
						>
							<dt class="font-light leading-6 text-пкфн-600">
								<div>Дети:</div>
							</dt>
							<dd class="mt-1 font-medium leading-6 text-neutral-600">
								{{ props.reservation.data.children }}
							</dd>
						</div>
						<div class="py-4 flex flex-col gap-2">
							<div class="flex w-full items-baseline justify-between">
								<dt class="font-light leading-6 text-gray-600">
									<Popover>
										<template #toggle>
											<div
												class="font-light leading-none text-gray-600 outline-none border-b border-gray-400 hover:border-gray-600 transition"
											>
												{{ detalizationText }}
											</div>
										</template>
										<template #content>
											<dl class="divide-y divide-gray-100 max-h-52 overflow-auto">
												<div
													class="py-1 px-4 flex w-full items-baseline justify-between"
													v-for="item in details"
													:key="item.date"
												>
													<dt class="font-light text-sm leading-6 text-gray-600">
														{{ item.date }}
													</dt>
													<dd class="mt-1 text-sm font-medium leading-6 text-neutral-600">
														{{ item.price?.toLocaleString() }}₽
													</dd>
												</div>
											</dl>
										</template>
									</Popover>
								</dt>
								<dd class="mt-1 font-medium leading-6 text-neutral-600">
									{{ basePrice?.toLocaleString() }}₽
								</dd>
							</div>
							<div class="flex w-full items-baseline justify-between">
								<dt class="font-light leading-6">
									<Popover>
										<template #toggle>
											<div
												class="font-light leading-none text-gray-600 outline-none border-b border-gray-400 hover:border-gray-600 transition"
											>
												Сервисный сбор
											</div>
										</template>
										<template #content>
											<div class="max-h-52 p-4 text-neutral-600 leading-tight text-sm">
												Благодаря этому сбору мы развиваем наш сервис и, в том числе,
												обеспечиваем путешественников круглосуточной поддержкой.
												<br />
												Данный сервисный сбор удерживатеся при отмене без уважительных причин.
											</div>
										</template>
									</Popover>
								</dt>
								<dd class="mt-1 font-medium leading-6 text-neutral-600">
									{{ servicePrice?.toLocaleString() }}₽
								</dd>
							</div>
						</div>
						<div class="pt-4 flex w-full items-baseline justify-between">
							<dt class="font-bold leading-6 text-neutral-00">
								<div>Итого:</div>
							</dt>
							<dd class="mt-1 font-bold leading-6 text-neutral-800">
								{{ totalPrice.toLocaleString() }}₽
							</dd>
						</div>
					</dl>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
