<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Heading from '@/Components/Heading.vue'
	import { Link, router } from '@inertiajs/vue3'
	import { computed, onMounted, ref } from 'vue'
	import dayjs from 'dayjs'
	import customParseFormat from 'dayjs/plugin/customParseFormat'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import Popover from '@/Components/Interactive/Popover.vue'
	import VueCountdown from '@chenfengyuan/vue-countdown'

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

	const remaining = ref(0)
	onMounted(() => {
		// const createdAt = new Date(props.reservation.data.created_at)
		const createdAt = dayjs(props.reservation.data.updated_at, 'DD.MM.YYYY HH:mm').toDate()
		const now = new Date()
		createdAt.setTime(createdAt.getTime() + 5 * 60 * 60 * 1000)
		remaining.value = createdAt.getTime() - now.getTime()
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
						subtitle="Вы должны оплатить не позднее чем через пять часов, иначе бронирование отменится."
					/>

					<div>
						<div
							class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100 dark:text-slate-200 dark:border-slate-500"
						>
							Ваша поездка:
						</div>
						<div class="mt-3">
							<div class="text-sm font-medium dark:text-slate-400">Даты:</div>
							<div class="dark:text-slate-200 font-medium">
								{{ props.reservation.data.start }} -
								{{ props.reservation.data.end }}
							</div>
						</div>
						<div class="mt-3">
							<div class="text-sm font-medium dark:text-slate-400">Гости:</div>
							<div class="dark:text-slate-200 font-medium">{{ props.reservation.data.guests }} гостя</div>
							<div
								class="font-medium dark:text-slate-200"
								v-if="props.reservation.data.children"
							>
								{{ props.reservation.data.children }} детей
							</div>
						</div>
					</div>
					<div>
						<div
							class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100 dark:text-slate-200 dark:border-slate-500"
						>
							Оплата:
						</div>
						<div class="flex items-baseline gap-5">
							<ButtonComponent
								class="mt-3 px-16"
								:auto-width="true"
								:label="`Перейти к оплате: ${props.reservation.data.first_payment?.toLocaleString()}₽`"
								@click="redirectToPayPage"
							/>
							<VueCountdown
								v-if="remaining"
								class="text-neutral-800 dark:text-slate-400 font-medium text-lg"
								:time="remaining"
								v-slot="{ hours, minutes }"
							>
								Осталось {{ hours }} ч. {{ minutes }} мин.
							</VueCountdown>
						</div>
						<div class="font-light text-sm text-neutral-800 leading-tight mt-4 dark:text-slate-400">
							Сейчас вам необходимо оплатить только 30% от общей суммы, чтобы забронировать жилье.
							Оставшуюся сумму вы сможете перевести хозяину при заселении. <br />Таким образом, вы можете
							забронировать жилье заранее и не переживать о полной оплате до момента заселения. <br />
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
							<div class="text-gray-600 font-light dark:text-slate-300">
								{{ props.reservation.data?.apartment?.category?.title }}
							</div>
							<div
								class="font-light text-xs text-gray-600 mt-1 dark:text-slate-300"
								v-html="subtitle"
							></div>
						</div>
					</div>
					<div
						class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100 dark:border-slate-600 dark:text-slate-200"
					>
						Детализация цены:
					</div>
					<dl class="divide-y divide-gray-100 dark:divide-slate-600">
						<div class="py-2 flex w-full items-baseline justify-between">
							<dt class="font-light leading-6 text-gray-600 dark:text-slate-300">
								<div>Гости:</div>
							</dt>
							<dd class="mt-1 font-medium leading-6 text-neutral-600 dark:text-slate-200">
								{{ props.reservation.data.guests }}
							</dd>
						</div>
						<div
							class="py-2 flex w-full items-baseline justify-between"
							v-if="props.reservation.data.children > 0"
						>
							<dt class="font-light leading-6 text-gray-600 dark:text-slate-300">
								<div>Дети:</div>
							</dt>
							<dd class="mt-1 font-medium leading-6 text-neutral-600 dark:text-slate-200">
								{{ props.reservation.data.children }}
							</dd>
						</div>
						<div class="py-4 flex flex-col gap-2">
							<div class="flex w-full items-baseline justify-between">
								<dt class="font-light leading-6 text-gray-600">
									<Popover>
										<template #toggle>
											<div
												class="font-light leading-none text-gray-600 dark:text-slate-300 outline-none border-b border-gray-400 dark:border-slate-300 hover:border-gray-600 transition"
											>
												{{ detalizationText }}
											</div>
										</template>
										<template #content>
											<dl
												class="divide-y divide-gray-100 dark:divide-slate-600 max-h-52 overflow-auto"
											>
												<div
													class="py-1 px-4 flex w-full items-baseline justify-between"
													v-for="item in details"
													:key="item.date"
												>
													<dt
														class="font-light text-sm leading-6 text-gray-600 dark:text-slate-300"
													>
														{{ item.date }}
													</dt>
													<dd
														class="mt-1 text-sm font-medium leading-6 text-neutral-600 dark:text-slate-200"
													>
														{{ item.price?.toLocaleString() }}₽
													</dd>
												</div>
											</dl>
										</template>
									</Popover>
								</dt>
								<dd class="mt-1 font-medium leading-6 text-neutral-600 dark:text-slate-200">
									{{ props.reservation.data.price?.toLocaleString() }}₽
								</dd>
							</div>
						</div>
						<div class="pt-4 flex w-full items-baseline justify-between">
							<dt class="font-bold leading-6 text-neutral-800 dark:text-slate-200">
								<div>Итого:</div>
							</dt>
							<dd class="mt-1 font-bold leading-6 text-neutral-800 dark:text-slate-200">
								{{ props.reservation.data.price?.toLocaleString() }}₽
							</dd>
						</div>
					</dl>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
