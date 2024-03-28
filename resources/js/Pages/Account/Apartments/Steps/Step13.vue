<script setup>
	import { router } from '@inertiajs/vue3'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import Form from '@/Pages/Account/Apartments/Form.vue'

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
	<Form
		:step="13"
		hidden-next-step
		:edit="props.apartment.data.status === 'published'"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: props.apartment.data.id,
					step: 12,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<div class="font-bold text-5xl dark:text-slate-200">Жилье добавлено</div>
			<div class="text-xl mt-4 dark:text-slate-400">Объявление отправлено на модерацию.</div>
			<div class="flex gap-4">
				<ButtonComponent
					class="mt-8 px-12"
					:outline="true"
					:auto-width="true"
					@click="
						router.visit(
							route('account.apartments.step', {
								apartment: props.apartment.data.id,
								step: 1,
							})
						)
					"
					label="Редактировать"
				/>
				<ButtonComponent
					class="mt-8 px-12"
					:outline="true"
					:auto-width="true"
					@click="router.visit(route('account.apartments.list'))"
					label="Перейти к моим объявлениям"
				/>
			</div>
		</div>
	</Form>
</template>
