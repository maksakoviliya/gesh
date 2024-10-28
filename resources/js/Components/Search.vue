<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { BiSearch, IoCloseOutline } from 'oh-vue-icons/icons'
	import { computed, onMounted, ref } from 'vue'
	import Popover from '@/Components/Interactive/Popover.vue'
	import Counter from '@/Components/Counter.vue'
	import VueDatePicker from '@vuepic/vue-datepicker'
	import '@vuepic/vue-datepicker/dist/main.css'
	import dayjs from 'dayjs'
	import 'dayjs/locale/ru'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import qs from 'query-string'
	import { router } from '@inertiajs/vue3'
	import { usePage } from '@inertiajs/vue3'
	import customParseFormat from 'dayjs/plugin/customParseFormat'
	import Input from '@/Components/Input.vue'

	addIcons(BiSearch, IoCloseOutline)

	dayjs.locale('ru')

	const page = usePage()
	const locationLabel = ref(page.props.query['city'] ?? 'Поиск')
	const durationLabel = ref('Неделя')

	const city = ref('')

	const guests = ref(page.props.query['guests'] ?? 2)
	const children = ref(page.props.query['children'] ?? 0)
	const guestLabel = computed(() => {
		const queryGuests = page.props.query['guests']
		return `${queryGuests ?? guests.value + children.value} чел.`
	})
	const handleSelectCity = (value) => {
		locationLabel.value = value
		city.value = value
	}

	const date = ref([])
	const isDateInitial = ref(true)
	const handleSetDates = (dates) => {
		isDateInitial.value = false
		date.value = dates
		let start = dayjs(dates[0])
		let end = dayjs(dates[1])
		if (start.date() === end.date()) {
			durationLabel.value = `${start.format('DD MMM')}`
			return
		}
		if (start.month() === end.month()) {
			durationLabel.value = `${start.date()} - ${end.date()} ${end.format('MMM')}`
			return
		}
		durationLabel.value = `${start.format('DD MMM')} - ${end.format('DD MMM')}`
	}

	const priceForPeriod = ref(page.props.query['priceForPeriod'])
	const priceMin = ref(page.props.query['priceMin'])
	const priceMax = ref(page.props.query['priceMax'])

	onMounted(() => {
		if (page.props.query['start'] && page.props.query['end']) {
			dayjs.extend(customParseFormat)
			let start = dayjs(page.props.query['start'], 'DD_MM_YYYY')
			let end = dayjs(page.props.query['end'], 'DD_MM_YYYY')
			if (start.date() === end.date()) {
				durationLabel.value = `${start.format('DD MMM')}`
				return
			}
			if (start.month() === end.month()) {
				durationLabel.value = `${start.date()} - ${end.date()} ${end.format('MMM')}`
			} else {
				durationLabel.value = `${start.format('DD MMM')} - ${end.format('DD MMM')}`
			}
			date.value = [
				dayjs(page.props.query['start'], 'DD_MM_YYYY').toDate(),
				dayjs(page.props.query['end'], 'DD_MM_YYYY').toDate(),
			]
		} else {
			date.value = [dayjs().toDate(), dayjs().add(1, 'week').toDate()]
		}
	})

	const onSubmit = () => {
		const params = page.props.query
		params['start'] = !!isDateInitial.value ? null : dayjs(date.value[0]).format('DD_MM_YYYY')
		params['end'] = !!isDateInitial.value ? null : dayjs(date.value[1]).format('DD_MM_YYYY')
		params['guests'] = guests.value
		params['children'] = children.value
		params['priceForPeriod'] = priceForPeriod.value
		params['priceMin'] = priceMin.value
		params['priceMax'] = priceMax.value

		const url = qs.stringifyUrl(
			{
				url: route('home'),
				query: params,
			},
			{ skipNull: true }
		)

		router.visit(url, {
			only: ['apartments'],
		})
	}

	const isDark = computed(
		() => localStorage.getItem('color-theme') === 'dark' || document.documentElement.classList.contains('dark')
	)
</script>

<template>
	<Popover max-width-class="max-w-3xl">
		<template #toggle>
			<div
				class="border dark:border-slate-500 w-full md:w-auto py-2 rounded-full shadow-sm hover:shadow-md transition cursor-pointer"
			>
				<div class="flex flex-row items-center justify-between">
					<div class="text-sm font-semibold px-6 dark:text-slate-200">
						{{ locationLabel }}
					</div>
					<div
						class="hidden sm:block text-sm font-semibold px-6 border-x-[1px] flex-1 text-center dark:text-slate-200"
					>
						{{ durationLabel }}
					</div>
					<div class="text-sm pl-6 pr-2 text-gray-600 dark:text-slate-200 flex flex-row items-center gap-3">
						<div class="hidden sm:block font-semibold">{{ guestLabel }}</div>
						<div
							class="p-2 bg-sky-600 dark:bg-sky-800 w-9 h-9 rounded-full text-white flex flex-col items-center justify-center"
							@click.prevent="onSubmit"
						>
							<OhVueIcon name="bi-search" />
						</div>
					</div>
				</div>
			</div>
		</template>
		<template #content="contentProps">
			<div class="p-4 flex flex-col gap-4 bg-white dark:bg-slate-800">
				<button
					@click="contentProps.close"
					class="w-10 h-10 rounded-full md:hidden border-[1px] border-neutral-400 dark:border-slate-400 flex items-center justify-center cursor-pointer dark:text-slate-400 dark:hover:opacity-100 dark:hover:text-slate-100 dark:hover:border-slate-100 hover:opacity-80 transition"
				>
					<OhVueIcon name="io-close-outline" />
				</button>

				<div class="flex items-stretch flex-col md:flex-row gap-2 md:gap-4 w-full justify-between">
					<div class="h-full w-full">
						<VueDatePicker
							:model-value="date"
							@update:model-value="handleSetDates"
							no-disabled-range
							range
							:partial-range="false"
							:inline="{ input: false }"
							text-input
							auto-apply
							:key="isDark"
							:dark="isDark"
							:month-change-on-scroll="false"
							min-range="1"
							max-range="30"
							month-name-format="long"
							calendar-class-name="dark:bg-slate-800"
							locale="ru"
							format="dd.MM.yyyy"
							placeholder="Выберите даты"
							:min-date="new Date()"
							:enable-time-picker="false"
							:hide-navigation="['month', 'year', 'time']"
						/>
					</div>
					<div class="h-full overflow-auto w-full">
						<Counter
							v-model="guests"
							class="mt-4"
							title="Гости"
							subtitle="Укажите количество гостей"
						/>
						<Counter
							v-model="children"
							class="mt-4"
							title="Дети"
							subtitle="0-12 лет"
						/>
					</div>
				</div>
				<div class="border-t mt-4 pt-4 border-gray-300 dark:border-slate-500">
					<h4 class="font-semibold text-neutral-200 dark:text-slate-200">Цена:</h4>
					<div class="flex flex-col md:flex-row items-center justify-between w-full gap-4 mt-4">
						<!--						<SwitchGroup-->
						<!--							as="div"-->
						<!--							class="flex items-center gap-3 text-neutral-500 mt-4 min-w-max"-->
						<!--						>-->
						<!--							<SwitchLabel-->
						<!--								class="cursor-pointer text-sm flex flex-col"-->
						<!--								:class="!priceForPeriod ? 'text-neutral-800 dark:text-slate-300' : ''"-->
						<!--							>-->
						<!--								За ночь-->
						<!--							</SwitchLabel>-->
						<!--							<Switch-->
						<!--								v-model="priceForPeriod"-->
						<!--								:class="priceForPeriod ? 'bg-sky-600' : 'bg-gray-200 dark:bg-slate-600'"-->
						<!--								class="relative inline-flex h-6 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"-->
						<!--							>-->
						<!--								<span-->
						<!--									aria-hidden="true"-->
						<!--									:class="priceForPeriod ? 'translate-x-4' : 'translate-x-0'"-->
						<!--									class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"-->
						<!--								/>-->
						<!--							</Switch>-->
						<!--							<SwitchLabel-->
						<!--								class="cursor-pointer text-sm flex items-center gap-1"-->
						<!--								:class="priceForPeriod ? 'text-neutral-800 dark:text-slate-200' : ''"-->
						<!--							>-->
						<!--								За всё время-->
						<!--							</SwitchLabel>-->
						<!--						</SwitchGroup>-->
						<Input
							id="priceMin"
							type="number"
							v-model="priceMin"
							label="От"
						/>
						<span class="text-neutral-400 dark:text-slate-200 hidden md:inline">-</span>
						<Input
							id="priceMax"
							type="number"
							v-model="priceMax"
							label="До"
						/>
					</div>
				</div>
				<div class="flex gap-4 justify-end pb-16 md:pb-0">
					<ButtonComponent
						label="Поиск"
						:auto-width="true"
						class="px-8 w-full md:w-auto"
						@click.prevent="onSubmit"
					/>
				</div>
			</div>
		</template>
	</Popover>
</template>

<style>
	.dp__theme_light {
		@apply dark:bg-slate-800;
	}
	.dp__cell_disabled {
		@apply line-through;
	}
</style>
