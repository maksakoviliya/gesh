<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Categories from '@/Components/Categories.vue'
	import Container from '@/Components/Container.vue'
	import Map from '@/Components/Map/Map.vue'
	import { ref } from 'vue'
	import ViewToggler from '@/Components/ViewToggler.vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiViewGrid } from 'oh-vue-icons/icons'

	addIcons(HiViewGrid)

	const props = defineProps({
		categories: Object,
		apartments: Object,
	})

	const markers = ref(
		props.apartments.data.map((item) => {
			return {
				center: [item.lat, item.lon],
				img: item.media[0]?.src,
			}
		})
	)
</script>

<template>
	<AppLayout>
		<Container>
			<Categories :categories="categories.data" />
			<Map
				class="mt-24"
				:is-input="false"
				:lat="87.98709856259356"
				:lon="52.92596754124867"
				:markers="markers"
			/>
			<ViewToggler :to="route('home')">
				<div class="flex text-sm font-semibold items-center gap-3">
					Показать список
					<OhVueIcon
						name="hi-view-grid"
						scale="1.2"
					/>
				</div>
			</ViewToggler>
		</Container>
	</AppLayout>
</template>
