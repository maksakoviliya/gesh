<script setup>
	import dayjs from 'dayjs'
	import 'dayjs/locale/ru'
	import utc from 'dayjs/plugin/utc'
	import timezone from 'dayjs/plugin/timezone'
	dayjs.locale('ru')
	dayjs.extend(utc)
	dayjs.extend(timezone)

	const props = defineProps({
		event: Object,
	})
</script>

<template>
	<div>
		<div>
			Title: <b>{{ props.event.title }}</b>
		</div>
		<div>Start: {{ dayjs(props.event.start).tz('Europe/Moscow').format('DD.MM.YYYY HH:mm') }}</div>
		<div>End: {{ dayjs(props.event.end).tz('Europe/Moscow').format('DD.MM.YYYY HH:mm') }}</div>
	</div>
</template>
