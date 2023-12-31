<script setup>
	import { ref, onMounted, computed } from 'vue'
	import VueDatePicker from '@vuepic/vue-datepicker'
	import '@vuepic/vue-datepicker/dist/main.css'
	import useToasts from '@/hooks/useToasts'

	const props = defineProps({
		start: {
			type: Date,
			required: true,
		},
		end: {
			type: Date,
			required: true,
		},
		disabledDates: {
			type: Array,
			default: () => [],
		},
	})

	const date = computed(() => {
		return [props.start, props.end]
	})

	const emit = defineEmits(['setDates', 'invalidSelect'])

	const handleSelect = (value) => {
		emit('setDates', {
			start: value[0],
			end: value[1],
		})
	}

	const { errorToast } = useToasts()

	const handleInvalidSelect = (date) => {
		emit('invalidSelect', date)
		errorToast('Выбранный диапазон дат недоступен.')
	}

	const isDark = computed(
		() => localStorage.getItem('color-theme') === 'dark' || document.documentElement.classList.contains('dark')
	)
</script>

<template>
	<VueDatePicker
		:model-value="date"
		@update:model-value="handleSelect"
		no-disabled-range
		multi-calendars
		:dark="isDark"
		@invalid-select="handleInvalidSelect"
		:partial-range="false"
		auto-apply
		:month-change-on-scroll="false"
		max-range="30"
		:disabled-dates="props.disabledDates"
		month-name-format="long"
		locale="ru"
		format="dd.MM.yyyy"
		placeholder="Выберите даты"
		:min-date="new Date()"
		:enable-time-picker="false"
		:hide-navigation="['month', 'time']"
	>
	</VueDatePicker>
</template>

<style>
	.dp__theme_dark {
		--dp-background-color: rgb(30, 41, 59);
		--dp-border-color: rgb(51, 65, 85);
		--dp-menu-border-color: rgb(51, 65, 85);
	}
	.dp__cell_disabled {
		@apply line-through;
	}
	.dp__range_start,
	.dp__range_end,
	.dp__range_between {
		@apply bg-blue-500 text-white border-none rounded-full;
		background: var(--dp-primary-color);
	}
	.dp__range_start,
	.dp__date_hover_start:hover {
		background: linear-gradient(to right bottom, rgb(255, 255, 255) 50%, var(--dp-primary-color) 50%);
	}
	.dp__range_end,
	.dp__date_hover_end:hover {
		background: linear-gradient(to right bottom, var(--dp-primary-color) 50%, rgb(255, 255, 255) 50%);
	}
	.dp__date_hover_end,
	.dp__date_hover_start,
	.dp__date_hover {
		@apply rounded-full border-none;
	}
	.dp__date_hover_end:hover,
	.dp__date_hover_start:hover,
	.dp__date_hover:hover {
		@apply rounded-full border-none text-white;
	}
</style>
