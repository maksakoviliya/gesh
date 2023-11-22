<script setup>
	import { router } from '@inertiajs/vue3'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'

	const routes = ref([
		{
			id: 'account',
			route: route('account.index'),
			label: 'Аккаунт',
		},
		{
			id: 'apartments',
			route: route('account.apartments.list'),
			label: 'Объекты',
		},
		{
			id: 'apartments.create',
			route: route('account.apartments.create'),
			label: 'Объявление отправлено на модерацию',
		},
	])

	const props = defineProps({
		apartment: Array | Object,
	})
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
				<div class="font-bold text-5xl">Жилье добавлено</div>
				<div class="text-xl mt-4">Объявление отправлено на модерацию.</div>
				<ButtonComponent
					class="mt-8 px-12"
					:outline="true"
					:auto-width="true"
					@click="router.visit(route('account.apartments.list'))"
					label="Перейти к моим объявлениям"
				/>
			</div>
		</Container>
	</AppLayout>
</template>
