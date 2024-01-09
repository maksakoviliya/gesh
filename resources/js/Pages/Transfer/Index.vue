<script setup>
	import PageBanner from '@/Components/PageBanner.vue'
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import { router, useForm, usePage } from '@inertiajs/vue3'
	import useToasts from '@/hooks/useToasts'
	import PhoneInput from '@/Components/PhoneInput.vue'
	import Input from '@/Components/Input.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import EmptyState from '@/Components/EmptyState.vue'

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
	])

	const page = usePage()
	const form = useForm({
		name: page.props.user?.data?.name,
		phone: page.props.user?.data?.phone,
	})
	const { successToast } = useToasts()

	const done = ref(false)

	const submit = () => {
		form.post(route('transfer.schedule'), {
			onSuccess: () => {
				form.reset()
				done.value = true
				successToast('Заявка на трансфер отправлена')
			},
			preserveScroll: true,
		})
	}
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<PageBanner
				class="mt-6"
				srcset="
                /img/ServicesBanner/Transfer/transfer_w_190.jpg 190w,
                /img/ServicesBanner/Transfer/transfer_w_628.jpg 628w,
                /img/ServicesBanner/Transfer/transfer_w_850.jpg 850w,
                /img/ServicesBanner/Transfer/transfer_w_960.jpg 960w"
				src="/img/ServicesBanner/Transfer/transfer_w_960.jpg"
				alt="transfer"
				title="Трансфер"
				subtitle="Большой выбор различного вида трансфера"
			/>
		</Container>

		<Container
			class="mt-6"
			:xs="true"
		>
			<EmptyState
				v-if="done"
				title="Заявка на оформление трансфера принята"
				subtitle="Ожидайте, скоро наш специалист свяжется с вами и уточнит все детали по трансферу и ответит на все ваши вопросы"
				action-label="Забронировать жилье"
				@click="router.visit('/')"
			/>
			<div
				class="flex flex-col gap-3 mt-10 h-[40vh] justify-center"
				v-else
			>
				<div class="text-2xl md:text-4xl font-semibold text-neutral-800 dark:text-white">
					Забронировать трансфер
				</div>
				<Input
					class="mt-10"
					v-model="form.name"
					name="name"
					:error="form.errors.name"
					label="Как вас зовут"
					id="name"
				/>
				<PhoneInput
					v-model="form.phone"
					name="phone"
					:error="form.errors.phone"
					label="Телефон"
					id="phone"
				/>
				<ButtonComponent
					label="Отправить"
					:auto-width="true"
					class="max-w-xs mt-4 text-xl"
					@click="submit"
				/>
			</div>
		</Container>
	</AppLayout>
</template>
