<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Gallery from '@/Components/Gallery.vue'
	import Heading from '@/Components/Heading.vue'
	import { computed, ref } from 'vue'
	import Counter from '@/Components/Counter.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Avatar from '@/Components/Avatar.vue'
	import { useForm } from '@inertiajs/vue3'
	import dayjs from 'dayjs'
	import useToasts from '@/hooks/useToasts'
	import Datepicker from '@/Components/Datepicker.vue'
	import Map from '@/Components/Map/Map.vue'
	import Popover from '@/Components/Interactive/Popover.vue'

	const props = defineProps({
		apartment: Array | Object,
		hasICalLinks: Boolean,
	})

	const getTitle = () => {
		const category = [
			props.apartment.data.category?.title,
			props.apartment.data.title ?? null,
			props.apartment.data.city,
		]
		return category.filter((item) => !!item).join(', ')
	}

	const getSubtitle = () => {
		const result = [
			`${props.apartment.data.guests} гостей`,
			`${props.apartment.data.bedrooms} спальня`,
			`${props.apartment.data.beds} кровать`,
			`${props.apartment.data.bathrooms} ванная`,
		]
		return result.filter((item) => !!item).join(' · ')
	}

	const form = useForm({
		start: null,
		end: null,
		range: 2,
		guests: 2,
		children: 0,
	})

	const detalizationText = computed(() => {
		let nights = null
		if (form.range <= 1 || form.range === 21) {
			nights = `${form.range} ночь`
		}
		if ((form.range > 1 && form.range <= 5) || (form.range > 21 && form.range <= 24)) {
			nights = `${form.range} ночи`
		}
		if ((form.range > 5 && form.range <= 20) || form.range > 24) {
			nights = `${form.range} ночей`
		}
		return `${nights}`
	})

	const handleSetDates = (dates) => {
		if (!dates) {
			form.start = null
			form.end = null
			return
		}
		const start = dayjs(dates.start)
		const end = dayjs(dates.end)
		form.start = start.set('hour', 15).set('minute', 0).toDate()
		form.end = end.set('hour', 12).set('minute', 0).toDate()
		form.range = end.diff(start, 'day')
	}

	const details = ref([])

	const basePrice = computed(() => {
		const start = dayjs(form.start)
		const end = dayjs(form.end)
		details.value = []
		let sum = 0
		for (let date = start; date.isBefore(end); date = date.add(1, 'day')) {
			const price =
				date.day() === 5 || date.day() === 6
					? props.apartment.data.weekends_price
					: props.apartment.data.weekdays_price
			const customPrice = props.apartment.data.dates.find((item) => {
				const customDate = dayjs(item.date)
				return customDate.isSame(date, 'day')
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

	const servicePrice = computed(() => {
		const commission = basePrice.value >= 100000 ? 0.15 : 0.15
		return Math.ceil(basePrice.value * commission)
	})

	const totalPrice = computed(() => {
		return basePrice.value + servicePrice.value
	})

	const { errorToast } = useToasts()

	const createReservationRequest = () => {
		return form.post(
			route('reservation-requests.store', {
				apartment: props.apartment.data.id,
			}),
			{
				onError: (err) => {
					errorToast(Object.values(err)[0])
				},
			}
		)
	}

	const markers = ref([
		{
			center: [props.apartment.data.lat, props.apartment.data.lon],
			img: props.apartment.data.media[0]?.src,
		},
	])
</script>

<template>
	<AppLayout>
		<Container sm>
			<div
				v-if="props.apartment.data.address"
				class="text-3xl font-semibold"
			>
				{{ props.apartment.data.address }}
			</div>
			<Gallery
				class="mt-6"
				:images="apartment.data.media"
			/>
			<div class="flex flex-col items-start lg:flex-row gap-6 justify-between mt-6 relative">
				<div class="w-full lg:w-2/3">
					<Heading
						:title="getTitle()"
						:subtitle="getSubtitle()"
					/>
					<hr class="my-4 dark:border-slate-600" />
					<div class="flex justify-between items-start gap-x-6">
						<div class="flex flex-col gap-2">
							<div class="flex items-center min-w-0 gap-x-4">
								<Avatar
									:src="props.apartment.data.owner?.avatar"
									class="h-12 w-12 flex-none rounded-full bg-gray-50"
								/>
								<div class="text-sm font-semibold leading-6 text-gray-900 dark:text-slate-100">
									{{ props.apartment.data.owner?.name ?? '-' }}
								</div>
							</div>
						</div>
						<div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
							<p class="text-sm leading-6 text-gray-900 dark:text-slate-200">Владелец</p>
							<p class="mt-1 text-xs leading-5 text-gray-500 dark:text-slate-400">
								На сайте
								<time datetime="2023-01-23T13:23Z">
									{{ props.apartment.data.owner?.since ?? '-' }}
								</time>
							</p>
						</div>
					</div>
					<template v-if="!!props.apartment.data.features.length">
						<hr class="my-4 dark:border-slate-600" />
						<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
							<div
								v-for="feature in props.apartment.data.features"
								:key="feature.id"
								class="flex items-center gap-3"
							>
								<div
									class="text-neutral-800 dark:text-slate-100"
									v-html="feature.icon"
								></div>
								<div class="text-sm text-neutral-500 dark:text-slate-400">{{ feature.title }}</div>
							</div>
						</div>
					</template>
					<!--                    <hr class="my-4"/>-->
					<!--                    <div class="text-xl">-->
					<!--                        {{ props.apartment.data.category?.title }}-->
					<!--                    </div>-->
					<div
						class="mt-4 py-4 border-t dark:border-slate-600 dark:text-slate-400"
						v-if="props.apartment.data.description"
					>
						{{ props.apartment.data.description }}
					</div>
					<div
						class="mt-4 py-4 border-t dark:border-slate-600"
						v-if="props.apartment.data.lon && props.apartment.data.lat"
					>
						<Map
							:lon="props.apartment.data.lon"
							:lat="props.apartment.data.lat"
							:is-input="false"
							:markers="markers"
						/>
					</div>
				</div>
				<div
					class="relative lg:sticky rounded-lg shadow-lg border border-neutral-100 dark:border-slate-700 dark:shadow-gray-900 w-full lg:w-1/3 lg:top-28 p-6"
				>
					<div class="flex flex-wrap gap-2 xl:gap-4">
						<div class="text-2xl md:text-3xl font-semibold flex items-center gap-2 dark:text-white">
							{{ props.apartment.data.weekdays_price?.toLocaleString() }}₽
							<div
								class="flex flex-col"
								v-if="props.apartment.data.weekdays_price !== props.apartment.data.weekends_price"
							>
								<span
									class="text-neutral-500 dark:text-slate-400 font-light text-sm leading-none whitespace-nowrap"
									>ночь в</span
								>
								<span class="text-neutral-500 dark:text-slate-400 font-light text-sm leading-none"
									>будни</span
								>
							</div>
							<div v-else>
								<span
									class="text-neutral-500 dark:text-slate-400 font-light text-sm leading-none whitespace-nowrap"
									>/ ночь</span
								>
							</div>
						</div>
						<div
							class="text-2xl md:text-3xl font-semibold flex items-center gap-2 dark:text-white"
							v-if="props.apartment.data.weekdays_price !== props.apartment.data.weekends_price"
						>
							{{ props.apartment.data.weekends_price?.toLocaleString() }}₽
							<div class="flex flex-col">
								<span
									class="text-neutral-500 font-light text-sm dark:text-slate-400 leading-none whitespace-nowrap"
									>ночь в</span
								>
								<span class="text-neutral-500 font-light text-sm dark:text-slate-400 leading-none"
									>выходные</span
								>
							</div>
						</div>
					</div>
					<div class="mt-4">
						<div
							v-if="$page.props.admin && hasICalLinks"
							class="bg-sky-600 rounded-full w-fit lowercase py-0.5 mb-3 self-start px-4 text-white text-xs font-medium"
						>
							Календарь синхронизирован
						</div>
						<Datepicker
							range
							:start="form.start"
							:end="form.end"
							:disabled-dates="props.apartment.data.all_disabled_dates ?? []"
							:error="form.errors.start ?? form.errors.end ?? null"
							@setDates="handleSetDates"
						/>
						<Counter
							v-model="form.guests"
							class="mt-4"
							title="Гости"
							subtitle="Укажите количество гостей"
						/>
						<Counter
							v-model="form.children"
							class="mt-4"
							title="Дети"
							subtitle="0-12 лет"
						/>
					</div>
					<div class="flex flex-col gap-3 mt-4">
						<ButtonComponent
							:disabled="!(form.start && form.end)"
							v-if="props.apartment.data.fast_reserve && false"
							label="Моментальное бронирование"
						/>
						<ButtonComponent
							:disabled="!(form.start && form.end)"
							@click="createReservationRequest"
							label="Запрос на бронирование"
						/>
					</div>
					<div class="font-light text-sm text-center mt-3 text-neutral-500 dark:text-slate-400">
						Пока вы ни за что не платите, а просто свяжетесь с собственником жилья
					</div>
					<dl
						class="divide-y divide-gray-100 border-t dark:border-slate-700 mt-4"
						v-if="form.start && form.end"
					>
						<div class="py-4 flex flex-col gap-2">
							<div class="flex w-full items-baseline justify-between">
								<dt class="font-light leading-6 text-gray-600">
									<Popover>
										<template #toggle>
											<div
												class="font-light leading-none text-gray-600 dark:text-slate-400 outline-none border-b border-gray-400 dark:border-slate-600 hover:border-gray-600 dark:hover:border-slate-500 transition"
											>
												{{ detalizationText }}
											</div>
										</template>
										<template #content>
											<dl
												class="divide-y divide-gray-100 dark:divide-slate-700 max-h-52 overflow-auto"
											>
												<div
													class="py-1 px-4 flex w-full items-baseline justify-between"
													v-for="item in details"
													:key="item.date"
												>
													<dt
														class="font-light text-sm leading-6 text-gray-600 dark:text-slate-400"
													>
														{{ item.date }}
													</dt>
													<dd
														class="mt-1 text-sm font-medium leading-6 text-neutral-600 dark:text-slate-200"
													>
														{{ item.price?.toLocaleString() }}₽
													</dd>
												</div>
												<div class="pt-1 pb-2 px-4 flex w-full items-baseline justify-between">
													<dt class="font-light leading-6">
														<div
															class="font-light text-sm leading-none dark:text-slate-400 text-gray-600 outline-none"
														>
															Сервисный сбор
														</div>
													</dt>
													<dd
														class="mt-1 font-medium leading-6 text-neutral-600 dark:text-slate-100"
													>
														{{ servicePrice?.toLocaleString() }}₽
													</dd>
												</div>
											</dl>
										</template>
									</Popover>
								</dt>
								<dd class="mt-1 font-medium leading-6 text-neutral-600 dark:text-slate-100">
									{{ basePrice?.toLocaleString() }}₽
								</dd>
							</div>
						</div>
					</dl>
					<div
						class="border-t pt-4 flex flex-col gap-2 dark:border-slate-700"
						v-if="form.start && form.end"
					>
						<div class="flex w-full items-baseline justify-between">
							<dt class="font-bold leading-6 text-neutral-800 dark:text-slate-100">Итого:</dt>
							<dd class="mt-1 font-bold leading-6 text-lg text-neutral-800 dark:text-slate-100">
								{{ totalPrice?.toLocaleString() }}₽
							</dd>
						</div>
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
