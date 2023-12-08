<script setup>
	import AppartmentsCard from '@/Components/AppartmentsCard.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import { router } from '@inertiajs/vue3'

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
	<div
		v-else
		class="pt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-8"
	>
		<AppartmentsCard
			v-for="apartment in apartments.data"
			:key="apartment.id"
			:apartment="apartment"
		/>
	</div>
</template>
