<script setup>
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import Heading from '@/Components/Heading.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import { router } from '@inertiajs/vue3'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Card from '@/Pages/Account/Apartments/Card.vue'
	import CardInList from '@/Pages/Account/Reservations/CardInList.vue'

	defineProps({
		reservations: Object,
	})

	const routes = ref([
		{
			id: 'account',
			route: route('account.index'),
			label: 'Аккаунт',
		},
		{
			id: 'reservations',
			route: route('account.reservations.list'),
			label: 'Мои бронирования',
		},
	])
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<Heading
				class="mt-6"
				title="Мои бронирования"
				subtitle="Управляйте своими бронированиями"
			/>
			<EmptyState
				v-if="!reservations.data.length"
				title="Бронирований пока нет"
				subtitle="После выбора объекта он появится здесь для управления оплатой, отменой и тд."
			/>
			<div
				v-else
				class="pt-4"
			>
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
					<CardInList
						:reservation="reservation"
						v-for="reservation in reservations.data"
					/>
				</div>
			</div>
		</Container>

		<Container :sm="true">
			<div class="bg-white py-24 sm:py-32">
				<div class="mx-auto max-w-7xl px-6 lg:px-8">
					<div
						class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3"
					>
						<article class="flex max-w-xl flex-col items-start justify-between">
							<div class="flex items-center gap-x-4 text-xs">
								<time
									datetime="2020-03-16"
									class="text-gray-500"
									>Mar 16, 2020</time
								>
								<a
									href="#"
									class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100"
									>Marketing</a
								>
							</div>
							<div class="group relative">
								<h3
									class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
								>
									<a href="#">
										<span class="absolute inset-0"></span>
										Boost your conversion rate
									</a>
								</h3>
								<p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
									Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non
									aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla
									deserunt vel. Iusto corrupti dicta.
								</p>
							</div>
							<div class="relative mt-8 flex items-center gap-x-4">
								<img
									src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
									alt=""
									class="h-10 w-10 rounded-full bg-gray-50"
								/>
								<div class="text-sm leading-6">
									<p class="font-semibold text-gray-900">
										<a href="#">
											<span class="absolute inset-0"></span>
											Michael Foster
										</a>
									</p>
									<p class="text-gray-600">Co-Founder / CTO</p>
								</div>
							</div>
						</article>

						<!-- More posts... -->
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
