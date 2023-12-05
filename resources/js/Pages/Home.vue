<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Categories from '@/Components/Categories.vue'
	import Container from '@/Components/Container.vue'
	import Apartments from '@/Components/Apartments.vue'
	import ViewToggler from '@/Components/ViewToggler.vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiMap } from 'oh-vue-icons/icons'

	addIcons(HiMap)

	defineProps({
		categories: Array | null,
		apartments: Array | null,
	})
</script>

<template>
	<AppLayout>
		<Container>
			<Categories :categories="categories.data" />
			<Apartments :apartments="apartments" />
			<ViewToggler :to="route('home.map')">
				<div class="flex text-sm font-semibold items-center gap-3">
					Показать карту
					<OhVueIcon
						name="hi-map"
						scale="1.2"
					/>
				</div>
			</ViewToggler>
		</Container>
	</AppLayout>
</template>
