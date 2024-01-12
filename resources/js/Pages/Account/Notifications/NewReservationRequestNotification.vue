<script setup>
	import Avatar from '@/Components/Avatar.vue'
	import { Link, router } from '@inertiajs/vue3'

	const props = defineProps({
		notification: {
			type: Object,
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

	const goToChat = () => {
		router.visit(
			route('account.apartments.owner.chat', {
				apartment: props.notification.data.reservation_request.apartment.id,
				chat: props.notification.data.chat_id,
			})
		)
	}
</script>
<template>
	<div
		class="relative overflow-x-auto shadow-md cursor-pointer flex flex-col md:flex-row items-start md:items-center transition hover:bg-gray-100 justify-between px-6 py-4 sm:rounded-lg text-sm text-left text-gray-500 dark:text-gray-400"
		@click="goToChat"
	>
		<div>
			<div class="flex items-baseline gap-1">
				<div class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
					{{ notification.title }}
				</div>
				<div class="text-neutral-400 text-xs">| {{ notification.created_at }}</div>
			</div>
			<div class="flex flex-wrap items-center gap-1 mt-2">
				<div class="flex items-center gap-2">
					<Avatar :src="notification.data.reservation_request.user.avatar" />
					<div class="font-medium text-sm dark:text-white">
						{{ notification.data.reservation_request.user.name }}
					</div>
				</div>
				<div>хочет забронировать</div>
				<Link
					:href="
						route('account.apartments.calendar', {
							apartment: notification.data.reservation_request.apartment.id,
						})
					"
					class="flex items-center gap-2 group"
				>
					<Avatar
						square
						:src="notification.data.reservation_request.apartment?.media[0]?.src"
					/>
					<div class="font-medium text-sm dark:text-white group-hover:underline">ваш объект</div>
				</Link>
				<div>
					c {{ notification.data.reservation_request.start }} по
					{{ notification.data.reservation_request.end }} | на
					{{ notification.data.reservation_request.range }} ночей
				</div>
			</div>
		</div>
		<button
			v-if="!notification.read_at"
			class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
			@click.prevent.stop="markNotificationAsRead(notification.id)"
		>
			Прочитать
		</button>
	</div>
</template>
