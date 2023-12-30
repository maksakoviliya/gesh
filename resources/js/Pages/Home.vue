<script setup>
	import Apartments from '@/Components/Apartments/Apartments.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Categories from '@/Components/Categories.vue'

	import Container from '@/Components/Container.vue'
	import ViewToggler from '@/Components/ViewToggler.vue'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiMap } from 'oh-vue-icons/icons'
	import ServicesBanner from '@/Components/ServiceBanner/ServicesBanner.vue'

	addIcons(HiMap)

	defineProps({
		categories: Array | null,
		apartments: Array | null,
	})
</script>

<template>
	<AppLayout>
		<Container class="pb-32">
			<ServicesBanner class="mt-6" />
			<Categories :categories="categories.data" />
			<Apartments :apartments="apartments" />
			<ViewToggler :to="route('home.map')">
				<div class="flex text-sm font-semibold items-center gap-3">
					<span class="whitespace-nowrap">Показать карту</span>
					<OhVueIcon
						name="hi-map"
						scale="1.2"
					/>
				</div>
			</ViewToggler>
		</Container>
	</AppLayout>
</template>
