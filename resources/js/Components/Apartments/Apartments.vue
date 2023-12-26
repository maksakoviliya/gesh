<script setup>
	import EmptyState from '@/Components/EmptyState.vue'
	import { router } from '@inertiajs/vue3'
	import AppartmentsCard from '@/Components/Apartments/AppartmentsCard.vue'
	import Pagination from '@/Components/Pagination.vue'

	defineProps({
		apartments: Array | null,
	})
</script>

<template>
	<EmptyState
		title="Ничего не найдено"
		subtitle="Не удалось найти жилья по вашему запросу"
		action-label="Сбросить фильтр"
		@click="router.visit(route('home'))"
		v-if="!apartments.data.length"
	/>
	<template v-else>
		<div class="pt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3 md:gap-8">
			<AppartmentsCard
				v-for="apartment in apartments.data"
				:key="apartment.id"
				:apartment="apartment"
			/>
		</div>
		<Pagination
			class="mt-6 flex justify-center"
			:links="apartments.meta.links"
		/>
	</template>
</template>
