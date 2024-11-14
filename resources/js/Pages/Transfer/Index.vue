<script setup>
	import PageBanner from '@/Components/PageBanner.vue'
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import TransferGrid from '@/Components/Transfer/TransferGrid.vue'
	import TransferForm from '@/Pages/Transfer/TransferForm.vue'

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

		<TransferGrid class="mt-6" />

		<TransferForm />
	</AppLayout>
</template>
