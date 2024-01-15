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
		<template #title> Код для авторизации телеграм </template>
		<template #content>
			Код: <b class="text-neutral-900">{{ props.notification.data.code }}</b
			>. Если это были не вы - просто игнорируйте данное сообщение
		</template>
	</NotificationItem>
</template>
