<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import Container from '@/Components/Container.vue'
	import Heading from '@/Components/Heading.vue'
	import { ref } from 'vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import FullScreenLoader from '@/Components/Loaders/FullScreenLoader.vue'

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

	const props = defineProps({
		step: {
			type: Number,
		},
		hiddenNextStep: {
			type: Boolean,
			default: false,
		},
		nextButtonLabel: {
			type: String,
			default: 'Далее',
		},
		edit: {
			type: Boolean,
			required: true,
		},
	})

	const title = ref(props.edit ? 'Редактировать объект' : 'Добавить объект')
	const subtitle = ref(
		props.edit
			? 'Управляйте своим объектом недвижимости'
			: 'Как можно подробнее опишите объект, который вы хотите разместить'
	)

	const emit = defineEmits(['onNextStep', 'onPrevStep'])

	const loading = ref(false)
	const startLoading = () => {
		loading.value = true
	}
	const stopLoading = () => {
		loading.value = false
	}

	defineExpose({
		startLoading,
		stopLoading,
	})
</script>

<template>
	<AppLayout hidden-footer>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<div class="flex flex-col md:flex-row gap-4 items-center justify-between">
				<Heading
					class="mt-6"
					:title="title"
					:subtitle="subtitle"
				/>
				<!--				<ButtonComponent-->
				<!--					label="Сохранить и выйти"-->
				<!--					:disabled="true"-->
				<!--					:outline="true"-->
				<!--					class="max-w-xs"-->
				<!--					:small="true"-->
				<!--				/>-->
			</div>
			<div class="mt-10 flex flex-col gap-4">
				<slot></slot>
			</div>
			<div class="fixed inset-x-0 bottom-0 py-4 bg-white dark:bg-slate-800 border-t z-20">
				<Container :sm="true">
					<div class="flex justify-between gap-6">
						<ButtonComponent
							:disabled="props.step < 2"
							:auto-width="true"
							class="px-8"
							:outline="true"
							label="Назад"
							@click="emit('onPrevStep')"
						/>
						<ButtonComponent
							v-if="!props.hiddenNextStep"
							@click="emit('onNextStep')"
							:auto-width="true"
							class="px-8"
							:label="props.nextButtonLabel"
						/>
					</div>
				</Container>
			</div>
		</Container>
		<FullScreenLoader :loading="loading" />
	</AppLayout>
</template>
