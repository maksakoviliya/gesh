<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { BiSearch } from 'oh-vue-icons/icons'
	import { computed, onMounted, ref } from 'vue'
	import Popover from '@/Components/Interactive/Popover.vue'
	import Counter from '@/Components/Counter.vue'
	import VueDatePicker from '@vuepic/vue-datepicker'
	import '@vuepic/vue-datepicker/dist/main.css'
	import dayjs from 'dayjs'
	import 'dayjs/locale/ru'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import CitySearch from '@/Components/CitySearch.vue'
	import qs from 'query-string'
	import { router } from '@inertiajs/vue3'
	import { usePage } from '@inertiajs/vue3'

	addIcons(BiSearch)

	const page = usePage()
	const locationLabel = ref(page.props.query['city'] ?? 'Везде')
	const durationLabel = ref('Неделя')

	const city = ref('')

	const guests = ref(2)
	const children = ref(0)
	const guestLabel = computed(() => {
		const queryGuests = page.props.query['guests']
		return `${queryGuests ?? guests.value + children.value} чел.`
	})
	const handleSelectCity = (value) => {
		locationLabel.value = value
		city.value = value
	}

	const date = ref([dayjs().toDate(), dayjs().add(1, 'week').toDate()])
	const isDateInitial = ref(true)
	const handleSetDates = (dates) => {
		dayjs.locale('ru')
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

	const onSubmit = () => {
		const params = page.props.query
		params['city'] = !!city.value ? city.value : null
		params['start'] = !!isDateInitial.value ? null : dayjs(date.value[0]).format('DD_MM_YYYY')
		params['end'] = !!isDateInitial.value ? null : dayjs(date.value[1]).format('DD_MM_YYYY')
		params['guests'] = guests.value

		const url = qs.stringifyUrl(
			{
				url: route('home'),
				query: params,
			},
			{ skipNull: true }
		)

		router.visit(url)
	}
</script>

<template>
	<Popover max-width-class="max-w-3xl">
		<template #toggle>
			<div
				class="border dark:border-slate-500 w-full md:w-auto py-2 rounded-full shadow-sm hover:shadow-md transition cursor-pointer"
			>
				<div class="flex flex-row items-center justify-between">
					<div class="text-sm font-semibold px-6 darK:text-slate-200">
						{{ locationLabel }}
					</div>
					<div
						class="hidden sm:block text-sm font-semibold px-6 border-x-[1px] flex-1 text-center darK:text-slate-200"
					>
						{{ durationLabel }}
					</div>
					<div class="text-sm pl-6 pr-2 text-gray-600 darK:text-slate-200 flex flex-row items-center gap-3">
						<div class="hidden sm:block font-semibold">{{ guestLabel }}</div>
						<div
							class="p-2 bg-sky-600 dark:bg-sky-800 rounded-full text-white"
							@click.prevent="onSubmit"
						>
							<OhVueIcon name="bi-search" />
						</div>
					</div>
				</div>
			</div>
		</template>
		<template #content>
			<div class="p-4 flex flex-col gap-4">
				<div class="h-auto flex items-stretch flex-col md:flex-row gap-2 md:gap-4 w-full justify-between">
					<div class="h-full overflow-auto w-full">
						<CitySearch
							@select="handleSelectCity"
							:query="city.value"
						/>
					</div>
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
				<div class="flex gap-4 justify-end">
					<ButtonComponent
						label="Поиск"
						:auto-width="true"
						class="px-16"
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
