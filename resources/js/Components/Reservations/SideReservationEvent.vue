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
		<div class="text-neutral-800 dark:text-slate-200">
			Title: <b>{{ props.event.data.side_reservation.summary }}</b>
		</div>
		<div class="text-neutral-800 dark:text-slate-200">Start: {{ props.event.data.side_reservation.start }}</div>
		<div class="text-neutral-800 dark:text-slate-200">End: {{ props.event.data.side_reservation.end }}</div>
	</div>
</template>
