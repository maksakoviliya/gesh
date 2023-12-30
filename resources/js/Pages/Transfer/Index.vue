<script setup>
	import PageBanner from '@/Components/PageBanner.vue'
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import { useForm, usePage } from '@inertiajs/vue3'
	import useToasts from '@/hooks/useToasts'
	import PhoneInput from '@/Components/PhoneInput.vue'
	import Input from '@/Components/Input.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'

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

	const submit = () => {
		form.post(route('transfer.schedule'), {
			onSuccess: () => {
				form.reset()
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
			<div class="flex flex-col gap-3 mt-10">
				<div class="text-2xl font-semibold text-neutral-800">Забронировать трансфер</div>
				<Input
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
					label="Забронировать"
					:auto-width="true"
					class="max-w-xs mt-4"
					@click="submit"
				/>
			</div>
		</Container>
	</AppLayout>
</template>
