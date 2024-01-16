<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Tabs from '@/Components/Tabs/Tabs.vue'
	import Tab from '@/Components/Tabs/Tab.vue'
	import { computed, ref } from 'vue'
	import { router, usePage } from '@inertiajs/vue3'
	import Heading from '@/Components/Heading.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import Pagination from '@/Components/Pagination.vue'
	import NewReservationRequestNotification from '@/Pages/Account/Notifications/NewReservationRequestNotification.vue'
	import NewTelegramAuthCodeGeneratedNotification from '@/Pages/Account/Notifications/NewTelegramAuthCodeGeneratedNotification.vue'
	import UserReservationPaidNotification from '@/Pages/Account/Notifications/UserReservationPaidNotification.vue'
	import ReservationCreatedNotification from '@/Pages/Account/Notifications/ReservationCreatedNotification.vue'

	const page = usePage()
	const type = computed(() => {
		return page.props.query.type ?? null
	})

	const applyFilter = (filter) => {
		router.visit(route('account.notifications.index', filter))
	}

	const routes = ref([
		{
			id: 'account',
			route: route('account.index'),
			label: 'Аккаунт',
		},
		{
			id: 'notifications',
			route: route('account.notifications.index'),
			label: 'Уведомления',
		},
	])

	const props = defineProps({
		notifications: {
			type: [Object, null],
		},
	})
</script>

<template>
	<AppLayout>
		<Container sm>
			<Breadcrumbs :routes="routes" />
			<Heading
				class="mt-8"
				title="Уведомления"
			/>

			<Tabs>
				<Tab
					:active="!type || type === 'all'"
					@click="applyFilter({ type: 'all' })"
					>Все</Tab
				>
				<Tab
					:active="type === 'unread'"
					@click="applyFilter({ type: 'unread' })"
					>Непрочитанные</Tab
				>
			</Tabs>

			<EmptyState
				v-if="props.notifications.meta?.total === 0"
				title="Уведомлений не найдено"
				subtitle="Попробуйте посмотерть в другом разделе или измените параметры поиска"
			/>

			<template v-else>
				<div class="h-10"></div>
				<div
					v-for="notification in props.notifications.data"
					:key="notification.id"
				>
					<NewReservationRequestNotification
						v-if="
							notification.type === 'App\\Notifications\\ReservationRequest\\CreatedNotification' &&
							notification.data?.reservation_request?.apartment
						"
						:notification="notification"
					/>
					<NewTelegramAuthCodeGeneratedNotification
						v-else-if="
							notification.type ===
							'App\\Notifications\\Telegram\\NewTelegramAuthCodeGeneratedNotification'
						"
						:notification="notification"
					/>
					<UserReservationPaidNotification
						v-else-if="
							notification.type === 'App\\Notifications\\Reservation\\UserReservationPaidNotification'
						"
						:notification="notification"
					/>
					<ReservationCreatedNotification
						v-else-if="notification.type === 'App\\Notifications\\Reservation\\CreatedNotification'"
						:notification="notification"
					/>
					<div v-else>{{ notification.type }}</div>
				</div>
			</template>

			<Pagination
				v-if="props.notifications.meta?.last_page > 1"
				:links="props.notifications.meta.links"
				class="mt-8 w-full flex justify-center"
			/>
		</Container>
	</AppLayout>
</template>
