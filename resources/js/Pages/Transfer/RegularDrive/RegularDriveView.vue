<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import PageBanner from '@/Components/PageBanner.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import Container from '@/Components/Container.vue'
	import { ref } from 'vue'
	import BookingSeats from '@/Pages/Transfer/BookingSeats.vue'
	import TransferForm from '@/Pages/Transfer/TransferForm.vue'

	const props = defineProps(['drive'])

	const routes = ref([
		{
			id: 'home',
			route: route('home'),
			label: 'Главная',
		},
		{
			id: 'transfer',
			route: route('transfer.index'),
			label: 'Трансфер',
		},
		{
			id: 'drive',
			route: '#',
			label: props.drive.data.name,
		},
	])
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<PageBanner
				class="mt-6 md:mt-10"
				alt="transfer"
				:src="drive.data.img"
				:title="drive.data.name"
				:subtitle="drive.data.description"
			/>

			<div class="flex flex-col md:flex-row gap-4 mt-6 md:mt-12">
				<BookingSeats
					class="w-full md:w-7/12"
					:drive="drive"
				/>
				<aside
					class="border dark:border-slate-600 rounded-2xl w-full p-4 text-neutral-800 dark:text-neutral-300"
				>
					<h1 class="font-semibold text-lg">Регулярный маршрут</h1>
					<div class="mt-3 flex flex-col gap-3">
						<div>
							Цена за место:
							<span class="text-neutral-900 font-bold dark:text-neutral-200">{{
								drive.data.price_formatted
							}}</span>
						</div>
						<h2>
							Отправление
							<span class="text-neutral-900 font-bold dark:text-neutral-200">ежедневно</span> из:
						</h2>
						<div>
							{{ drive.data.start_point }} в
							<span class="text-neutral-900 font-bold dark:text-neutral-200">{{
								drive.data.start_at
							}}</span
							>.
						</div>
						<h2>
							Прибытие в
							<span class="text-neutral-900 font-bold dark:text-neutral-200">{{
								drive.data.finish_point
							}}</span
							>.
						</h2>
						<div>
							Время в пути примерно
							<span class="text-neutral-900 font-bold dark:text-neutral-200"
								>{{ drive.data.duration }} час</span
							>.
						</div>
					</div>
				</aside>
			</div>
		</Container>

		<TransferForm />
	</AppLayout>
</template>
