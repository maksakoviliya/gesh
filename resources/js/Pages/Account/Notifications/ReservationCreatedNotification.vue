<script setup>
	import NotificationItem from '@/Pages/Account/Notifications/NotificationItem.vue'
	const props = defineProps({
		notification: {
			type: Object,
		},
	})
</script>
<template>
	<NotificationItem :notification="props.notification">
		<template #title> Бронирование успешно создано </template>
		<!--		<template #content>-->
		<!--			{{ props.notification.data }}-->
		<!--		</template>-->
	</NotificationItem>
</template>
