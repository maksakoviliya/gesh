<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import Container from '@/Components/Container.vue'
	import Heading from '@/Components/Heading.vue'
	import { ref } from 'vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import { router } from '@inertiajs/vue3'

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
			label: 'Добавить',
		},
	])

	defineProps({
		step: Number,
	})

	const emit = defineEmits(['onNextStep', 'onPrevStep'])
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<div class="flex flex-col md:flex-row gap-4 items-center justify-between">
				<Heading
					class="mt-6"
					title="Добавить объект"
					subtitle="Как можно подробнее опишите объект, который вы хотите разместить"
				/>
				<ButtonComponent
					label="Сохранить и выйти"
					:disabled="true"
					:outline="true"
					class="max-w-xs"
					:small="true"
				/>
			</div>
			<div class="mt-10 flex flex-col gap-4">
				<slot></slot>
			</div>
			<div class="fixed inset-x-0 bottom-0 py-4 bg-white border-t z-20">
				<Container :sm="true">
					<div class="flex justify-between gap-6">
						<ButtonComponent
							:disabled="step < 2"
							:auto-width="true"
							class="px-8"
							:outline="true"
							label="Назад"
							@click="emit('onPrevStep')"
						/>
						<ButtonComponent
							@click="emit('onNextStep')"
							:auto-width="true"
							class="px-8"
							label="Далее"
						/>
					</div>
				</Container>
			</div>
		</Container>
	</AppLayout>
</template>
