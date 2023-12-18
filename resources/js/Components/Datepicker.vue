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
		disable-year-select
		month-name-format="long"
		locale="ru"
		format="dd.MM.yyyy"
		placeholder="Выберите даты"
		:min-date="new Date()"
		:enable-time-picker="false"
		:hide-navigation="['month', 'year', 'time']"
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
</style>
