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

	const markNotificationAsRead = (id) => {
		router.visit(
			route('account.notifications.read', {
				notification: id,
			}),
			{
				method: 'post',
				only: ['notifications'],
			}
		)
	}
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

			<div
				v-else
				class="mt-10"
			>
				<div
					class="relative overflow-x-auto shadow-md flex justify-between px-6 py-4 sm:rounded-lg text-sm text-left text-gray-500 dark:text-gray-400"
					v-for="notification in props.notifications.data"
					:key="notification.id"
				>
					<NewReservationRequestNotification
						v-if="notification.type === 'App\\Notifications\\ReservationRequest\\CreatedNotification'"
						:notification="notification"
					/>
					<button
						v-if="!notification.read_at"
						class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
						@click="markNotificationAsRead(notification.id)"
					>
						Прочитать
					</button>
				</div>
			</div>

			<Pagination
				v-if="props.notifications.meta?.last_page > 1"
				class="mt-8 w-full flex justify-center"
			/>
		</Container>
	</AppLayout>
</template>
