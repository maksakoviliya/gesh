<script setup>
	import { useForm, usePage, Link } from '@inertiajs/vue3'
	import { computed, ref } from 'vue'
	import Counter from '@/Components/Counter.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import useToasts from '@/hooks/useToasts'

	const props = defineProps({
		drive: {
			type: Object,
		},
	})

	const page = usePage()

	const form = useForm({
		start_at: page.props?.query?.start_at ?? Object.keys(props.drive?.data?.dates)[4],
		seats_count: page.props?.query?.seats_count ?? 1,
	})

	const loading = ref(false)

	const setStartAt = (start_at) => {
		form.start_at = start_at
	}

	const { successToast, errorToast } = useToasts()
	const onSubmit = () => {
		form.post(
			route('transfer.regular-ride.booking', {
				drive: props.drive.data?.id,
			}),
			{
				preserveScroll: true,
				// onStart: ({ data }) => {
				// console.log('data', data, window.location)
				// sessionStorage.setItem('url.intended', route(''))
				// },
				onSuccess: (res) => {
					if (res.props?.flash?.info) {
						successToast(res.props.flash.info)
					}
				},
				onError: (err) => {
					console.log('err', err)
					errorToast(Object.values(err)[0])
				},
			}
		)
	}

	const price = computed(() => {
		return props.drive?.data?.price * (form?.seats_count ?? 1)
	})

	const availableSeatsText = computed(() => {
		let available = props.drive?.data?.passengers_limit
		if (form.start_at) {
			const selected = props.drive?.data.dates[form.start_at]
			available = selected?.available_seats
		}

		return `Осталось свободных мест: ${available}`
	})
</script>

<template>
	<div class="w-full">
		<div class="p-2 border dark:border-slate-600 rounded-2xl flex gap-2 overflow-x-auto no-scrollbar">
			<button
				v-for="date in Object.keys(props.drive?.data.dates)"
				:key="date"
				@click.prevent="setStartAt(date)"
				:disabled="loading"
				class="p-4 transition rounded-xl text-sm font-bold cursor-pointer disabled:opacity-40 disabled:pointer-events-none"
				:class="
					form.start_at === date
						? 'bg-sky-200 text-neutral-900 dark:bg-sky-800 dark:text-neutral-200'
						: 'bg-gray-200 text-neutral-800 hover:bg-sky-100 dark:bg-slate-700 dark:text-neutral-400 dark:hover:bg-sky-900 dark:hover:text-neutral-300'
				"
			>
				{{ date.slice(0, 5) }}
			</button>
		</div>
		<form
			@submit.prevent="onSubmit"
			class="mt-4 border dark:border-slate-600 rounded-2xl p-4 relative overflow-hidden"
		>
			<Counter
				v-model="form.seats_count"
				title="Количество мест"
				:subtitle="availableSeatsText"
			/>
			<div class="flex items-center justify-between">
				<h2 class="text-neutral-900 text-2xl font-bold dark:text-neutral-200">{{ price }} ₽</h2>
				<ButtonComponent
					:disabled="!$page.props.user"
					auto-width
					class="px-4 mt-5 self-center"
				>
					Забронировать
				</ButtonComponent>
			</div>
			<div
				class="absolute inset-0 bg-white dark:bg-slate-800 flex flex-col items-center justify-center dark:text-neutral-400"
				v-if="!form.start_at"
			>
				Выберите желаемую дату поездки
			</div>
			<div
				v-if="!$page.props.user"
				class="font-light text-sm text-right mt-3 text-neutral-500 dark:text-slate-400"
			>
				Забронировать трансфер могут только авторизованные пользователи,
				<Link
					:href="route('login')"
					class="hover:underline font-medium hover:text-neutral-200"
					>войдите</Link
				>
				или
				<Link
					:href="route('register')"
					class="hover:underline font-medium hover:text-neutral-200"
					>зарегистрируйтесь</Link
				>.
			</div>
		</form>
	</div>
</template>
