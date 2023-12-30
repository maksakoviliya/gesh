<script setup>
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import Heading from '@/Components/Heading.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import { router, usePage } from '@inertiajs/vue3'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Card from '@/Pages/Account/Apartments/Card.vue'
	import CardInList from '@/Pages/Account/Reservations/CardInList.vue'
	import Tab from '@/Components/Tabs/Tab.vue'
	import Tabs from '@/Components/Tabs/Tabs.vue'
	import ReservationRequestInList from '@/Components/ReservationRequests/ReservationRequestInList.vue'
	import qs from 'query-string'

	defineProps({
		reservations: Object,
		reservation_requests: Object,
	})

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
	])

	const page = usePage()
	const type = ref(page.props.query?.type ?? 'reservations')
	const selectTab = (type) => {
		const url = qs.stringifyUrl(
			{
				url: route(route().current()),
				query: {
					type,
				},
			},
			{ skipNull: true }
		)

		router.visit(url)
	}
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />

			<Heading
				class="mt-6"
				title="Мои бронирования"
				subtitle="Управляйте своими бронированиями"
			/>

			<Tabs class="mt-8">
				<Tab
					:active="type === 'reservations'"
					@click="selectTab('reservations')"
					>Бронирования</Tab
				>
				<Tab
					:active="type === 'reservation_requests'"
					@click="selectTab('reservation_requests')"
				>
					<div class="relative">
						Запросы на бронирование
						<div
							v-if="reservation_requests.data.length"
							class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-500 border-2 border-white rounded-full -top-2 -end-5 dark:border-gray-900"
						>
							{{ reservation_requests.data.length }}
						</div>
					</div>
				</Tab>
			</Tabs>

			<div v-if="type === 'reservations'">
				<EmptyState
					v-if="!reservations.data.length"
					title="Бронирований пока нет"
					subtitle="После выбора объекта он появится здесь для управления оплатой, отменой и тд."
				/>
				<div
					v-else
					class="pt-4"
				>
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
						<CardInList
							:reservation="reservation"
							v-for="reservation in reservations.data"
						/>
					</div>
				</div>
			</div>

			<div v-if="type === 'reservation_requests'">
				<EmptyState
					v-if="!reservation_requests.data.length"
					title="Бронирований пока нет"
					subtitle="После выбора объекта он появится здесь для управления оплатой, отменой и тд."
				/>
				<div
					v-else
					class="pt-4"
				>
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
						<ReservationRequestInList
							v-for="reservation_request in reservation_requests.data"
							:key="reservation_request.id"
							:reservation_request="reservation_request"
						/>
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
