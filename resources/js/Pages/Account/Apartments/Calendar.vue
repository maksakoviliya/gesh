<script>
	import FullCalendar from '@fullcalendar/vue3'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin from '@fullcalendar/interaction'
	import multiMonthPlugin from '@fullcalendar/multimonth'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import ruLocale from '@fullcalendar/core/locales/ru'
	import Input from '@/Components/Input.vue'
	import { useForm } from '@inertiajs/vue3'
	import Heading from '@/Components/Heading.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import useToasts from '@/hooks/useToasts'
	import { computed, ref } from 'vue'
	import dayjs from 'dayjs'
	import 'dayjs/locale/ru'
	import ICalLinks from '@/Components/ICalLinks.vue'
	import ReservationRequestEvent from '@/Pages/Account/Apartments/Calendar/ReservationRequestEvent.vue'
	import SideReservationEvent from '@/Components/Reservations/SideReservationEvent.vue'
	import Toggle from '@/Components/Inputs/Toggle.vue'

	export default {
		props: {
			apartment: Object | Array,
			events: Array,
		},
		components: {
			Toggle,
			SideReservationEvent,
			ReservationRequestEvent,
			ICalLinks,
			ButtonComponent,
			Heading,
			Input,
			Breadcrumbs,
			Container,
			AppLayout,
			FullCalendar, // make the <FullCalendar> tag available
		},
		data() {
			return {
				routes: [
					{
						id: 'account',
						route: route('account.index'),
						label: 'Аккаунт',
					},
					{
						id: 'apartments',
						route: route('account.apartments.list'),
						label: 'Объекты',
					},
					{
						id: 'apartments.apartment',
						route: route('account.apartments.step', {
							apartment: this.apartment.data.id,
							step: this.apartment.data.step,
						}),
						label: 'Объект',
					},
					{
						id: 'apartments.calendar',
						route: route('account.apartments.calendar', {
							apartment: this.apartment.data.id,
						}),
						label: 'Календарь',
					},
				],
				calendarOptions: {
					timeZone: 'Europe/Moscow',
					plugins: [dayGridPlugin, interactionPlugin, multiMonthPlugin],
					multiMonthMaxColumns: 1,
					// headerToolbar: false,
					locale: ruLocale,
					validRange: function (nowDate) {
						let start = new Date(nowDate)
						start.setMonth(new Date(nowDate).getMonth() - 1)
						let end = new Date(nowDate)
						end.setMonth(new Date(nowDate).getMonth() + 15)
						return {
							start,
							end,
						}
					},
					selectable: true,
					unselectCancel: '.form',
					slotLabelFormat: [
						{
							month: 'long',
							week: 'short',
						}, // top level of text
						{
							weekday: 'narrow',
							day: 'numeric',
						}, // lower level of text
					],
					slotDuration: {
						hours: 12,
					},
					dayCellContent: (day) => {
						let price = null
						const date = this.apartment.data.dates.find((item) => {
							const date = dayjs(item.date)
							const calendarDate = dayjs(day.date)
							return date.isSame(calendarDate, 'day')
						})
						if (!date) {
							const dayOfWeek = day.date.getDay()
							price = this.apartment.data?.weekdays_price
							if (dayOfWeek === 5 || dayOfWeek === 6) {
								price = this.apartment.data?.weekends_price
							}
						} else {
							price = date.price
						}
						return {
							html: `<div class="flex flex-col w-full h-full justify-between disabled">
		                       <div class="font-semibold text-right text-neutral-800 dark:text-slate-100">${day.dayNumberText}</div>
		                       <div class="font-light text-neutral-500 dark:text-slate-300 text-sm">${price}₽</div>
		                   </div>`,
						}
					},
					select: this.handleSelect,
					unselect: this.handleUnselect,
					eventClick: this.handleEventClick,
					events: this.events,
				},
			}
		},

		setup(props) {
			const { successToast } = useToasts()

			const priceForm = useForm({
				weekdays_price: props.apartment.data.weekdays_price,
				weekends_price: props.apartment.data.weekends_price,
				i_cal_links: props.apartment.data.i_cal_links ?? [],
			})

			const rangeForm = useForm({
				start: null,
				end: null,
				price: null,
				disabled: null,
			})

			const selectedEvent = ref()

			const submitPriceForm = () => {
				priceForm
					.transform((data) => {
						data.weekdays_price = parseInt(data.weekdays_price)
						data.weekends_price = parseInt(data.weekends_price)
						return data
					})
					.post(
						route(
							'account.apartments.price.update',
							{
								apartment: props.apartment.data.id,
							},
							{ preserveScroll: true }
						),
						{
							onSuccess: () => {
								let calendarApi = calendar.value.getApi()
								calendarApi.render()
								successToast('Данные обновлены!')
							},
						}
					)
			}

			const calendar = ref(null)
			const disabledDates = computed(() =>
				props.events.filter((item) => item.type === 'App\\Models\\DisabledDate')
			)

			const handleSelect = (range) => {
				console.log('range', range)
				selectedEvent.value = null
				rangeForm.start = range.startStr
				// rangeForm.end = range.endStr
				rangeForm.end = dayjs(range.endStr).subtract(1, 'day').hour(23).minute(59)

				// rangeForm.disabled = range.reduce((accumulator, currentValue) => {
				// 	accumulator || currentValue.start
				// }, false)
			}
			const submitRangeForm = () => {
				rangeForm
					.transform((data) => {
						data.price = parseInt(data.price)
						return data
					})
					.post(
						route(
							'account.apartments.calendar.update',
							{
								apartment: props.apartment.data.id,
							},
							{ preserveScroll: true }
						),
						{
							onSuccess: () => {
								let calendarApi = calendar.value.getApi()
								calendarApi.render()
								successToast('Цены обновлены!')
							},
						}
					)
			}
			const handleUnselect = () => {
				rangeForm.start = null
				rangeForm.end = null
				rangeForm.price = null
				rangeForm.disabled = null
			}

			const getRangeLabel = computed(() => {
				dayjs.locale('ru')
				let start = dayjs(rangeForm.start)
				let end = dayjs(rangeForm.end)

				if (start.date() === end.date()) {
					return `${start.format('DD MMM')}`
				}
				if (start.month() === end.month()) {
					return `${start.date()} - ${end.date()} ${end.format('MMM')}`
				}
				return `${start.format('DD MMM')} - ${end.format('DD MMM')}`
			})

			const handleEventClick = (val) => {
				selectedEvent.value = val
			}

			return {
				priceForm,
				submitPriceForm,
				rangeForm,
				submitRangeForm,
				handleSelect,
				handleUnselect,
				getRangeLabel,
				calendar,
				handleEventClick,
				selectedEvent,
				disabledDates,
			}
		},
	}
</script>

<template>
	<AppLayout>
		<Container>
			<Breadcrumbs :routes="routes" />
			<div class="flex flex-col items-start lg:flex-row w-full mt-4 xl:mt-12 relative">
				<div class="w-full h-auto md:w-2/3">
					<FullCalendar
						ref="calendar"
						:options="calendarOptions"
					/>
				</div>
				<div class="lg:px-6 pt-1 mt-8 lg:mt-0 w-full md:w-1/3 form lg:sticky lg:top-24">
					<template v-if="rangeForm.start && rangeForm.end">
						<Heading :title="getRangeLabel" />
						<div class="mt-8 flex flex-col gap-3">
							<Input
								v-model="rangeForm.price"
								type="number"
								:error="rangeForm.errors.price"
								label="Цена, ₽"
							/>
							<Toggle
								v-model="rangeForm.disabled"
								:label="
									rangeForm.disabled ? 'Недоступно для бронирования' : 'Доступно для бронирования'
								"
							/>
							<ButtonComponent
								:disabled="!rangeForm.isDirty"
								class="mt-6"
								label="Сохранить"
								@click="submitRangeForm"
							/>
						</div>
					</template>
					<template v-else-if="selectedEvent">
						<Heading title="Событие" />
						<div class="mt-8 flex flex-col gap-3">
							<ReservationRequestEvent
								:event="selectedEvent.event.extendedProps"
								v-if="selectedEvent.event.extendedProps.type === 'App\\Models\\ReservationRequest'"
							/>
							<SideReservationEvent
								:event="selectedEvent.event"
								v-if="selectedEvent.event.extendedProps.type === 'App\\Models\\SideReservation'"
							/>
							<!--							<ButtonComponent-->
							<!--								class="mt-6"-->
							<!--								label="Сохранить"-->
							<!--							/>-->
						</div>
					</template>
					<template v-else>
						<div class="text-lg font-medium text-neutral-800 dark:text-slate-200">Базовая цена</div>
						<div class="mt-3 flex flex-col gap-3">
							<Input
								v-model="priceForm.weekdays_price"
								type="number"
								id="weekdays_price"
								:error="priceForm.errors.weekdays_price"
								label="Цена в будни, ₽"
							/>
							<Input
								v-model="priceForm.weekends_price"
								type="number"
								id="weekends_price"
								:error="priceForm.errors.weekends_price"
								label="Цена в выходные, ₽"
							/>
						</div>
						<div class="text-lg font-medium text-neutral-800 dark:text-slate-200 mt-6">Синхронизация</div>
						<div class="mt-3 flex flex-col gap-3">
							<ICalLinks
								v-model="priceForm.i_cal_links"
								@reset="priceForm.clearErrors()"
								:errors="priceForm.errors"
							/>
						</div>
						<ButtonComponent
							:disabled="!priceForm.isDirty"
							class="mt-6"
							label="Сохранить"
							@click="submitPriceForm"
						/>
					</template>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>

<style>
	.fc-toolbar-title {
		@apply dark:text-slate-200;
	}

	.fc-col-header-cell {
		@apply dark:text-slate-400;
	}

	.fc-theme-standard td,
	.fc-theme-standard th {
		@apply dark:border-slate-400;
	}

	.fc-theme-standard .fc-scrollgrid {
		@apply dark:border-slate-400;
	}

	.side_reservation_event {
		@apply bg-yellow-500 border-yellow-200 dark:bg-yellow-800 dark:border-yellow-600 px-2 opacity-80 hover:opacity-100 cursor-pointer;
	}

	.fc .fc-bg-event.disabled_date_event {
		@apply bg-red-400;
	}
</style>
