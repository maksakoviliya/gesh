<script setup>
	import { router, useForm, usePage } from '@inertiajs/vue3'
	import { computed, ref } from 'vue'
	import Counter from '@/Components/Counter.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'

	const props = defineProps({
		drive: {
			type: Object,
		},
	})

	const page = usePage()

	const form = useForm({
		date: page.props?.query?.date,
		passengers: page.props?.query?.passengers ?? 1,
	})

	const loading = ref(false)

	const setDate = (date) => {
		form.date = date
	}

	const onSubmit = () => {
		console.log('Submit')
		// router.post()
	}

	const price = computed(() => {
		console.log(props.drive?.price, form.passengers)
		return props.drive?.price * (form?.passengers ?? 1)
	})

	const availableSeatsText = computed(() => {
		let available = props.drive.passengers_limit
		if (form.date) {
			const selected = props.drive.dates[form.date]
			available = selected?.available_seats
		}
		return `Осталось свободных мест: ${available - form.passengers}`
	})
</script>

<template>
	<div class="w-full">
		<div class="p-2 border dark:border-slate-600 rounded-2xl flex gap-2 overflow-x-scroll no-scrollbar">
			<button
				v-for="date in Object.keys(props.drive.dates)"
				:key="date"
				@click.prevent="setDate(date)"
				:disabled="loading"
				class="p-4 transition rounded-xl text-sm font-bold cursor-pointer disabled:opacity-40 disabled:pointer-events-none"
				:class="
					form.date === date
						? 'bg-sky-200 text-neutral-900 dark:bg-sky-800 dark:text-neutral-200'
						: 'bg-gray-200 text-neutral-800 hover:bg-sky-100 dark:bg-slate-700 dark:text-neutral-400 dark:hover:bg-sky-900 dark:hover:text-neutral-300'
				"
			>
				{{ date.slice(0, 5) }}
			</button>
		</div>
		<form
			@submit.prevent=""
			class="mt-4 border dark:border-slate-600 rounded-2xl p-4 relative overflow-hidden"
		>
			<Counter
				v-model="form.passengers"
				title="Количество мест"
				:subtitle="availableSeatsText"
			/>
			<div class="flex items-center justify-between">
				<h2 class="text-neutral-900 text-2xl font-bold dark:text-neutral-200">{{ price }} ₽</h2>
				<ButtonComponent
					auto-width
					class="px-4 mt-5 self-center"
				>
					Забронировать
				</ButtonComponent>
			</div>
			<div
				class="absolute inset-0 dark:bg-slate-800 flex flex-col items-center justify-center dark:text-neutral-400"
				v-if="!form.date"
			>
				Выберите желаемую дату поездки
			</div>
		</form>
	</div>
</template>
