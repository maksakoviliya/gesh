<script setup>
	import Avatar from '@/Components/Avatar.vue'
	import { Link } from '@inertiajs/vue3'

	defineProps({
		notification: Object,
	})
</script>
<template>
	<div>
		<div class="flex items-baseline gap-1">
			<div class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
				{{ notification.title }}
			</div>
			<div class="text-neutral-400 text-xs">| {{ notification.created_at }}</div>
		</div>
		<div class="flex items-center gap-1 mt-2">
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
				<Avatar :src="notification.data.reservation_request.apartment.media[0].src" />
				<div class="font-medium text-sm dark:text-white group-hover:underline">ваш объект</div>
			</Link>
			<div>
				c {{ notification.data.reservation_request.start }} по {{ notification.data.reservation_request.end }} |
				на {{ notification.data.reservation_request.range }} ночей
			</div>
		</div>
	</div>
</template>
