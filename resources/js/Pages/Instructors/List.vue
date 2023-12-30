<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import PageBanner from '@/Components/PageBanner.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import { router, Link } from '@inertiajs/vue3'
	import InstructorCard from '@/Components/Instructors/InstructorCard.vue'

	const routes = ref([
		{
			id: 'home',
			route: route('home'),
			label: 'Главная',
		},
		{
			id: 'instructors',
			route: route('instructors.list'),
			label: 'Инструкторы',
		},
	])

	const props = defineProps({
		instructors: {
			type: [Object, null],
		},
	})
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<PageBanner
				class="mt-6"
				srcset="
						/img/ServicesBanner/Instructors/instructors_w_190.jpg 190w,
						/img/ServicesBanner/Instructors/instructors_w_372.jpg 372w,
						/img/ServicesBanner/Instructors/instructors_w_509.jpg 509w,
						/img/ServicesBanner/Instructors/instructors_w_631.jpg 631w,
						/img/ServicesBanner/Instructors/instructors_w_748.jpg 748w,
						/img/ServicesBanner/Instructors/instructors_w_851.jpg 851w,
						/img/ServicesBanner/Instructors/instructors_w_919.jpg 919w,
						/img/ServicesBanner/Instructors/instructors_w_960.jpg 960w
					"
				src="/img/ServicesBanner/Instructors/instructors_w_960.jpg"
				alt="instructors"
				title="Инструкторы"
				subtitle="Опытные инструкторы готовы помочь вам освоить горные лыжи"
			/>
			<div class="mt-10">
				<EmptyState
					v-if="!props.instructors?.data?.length"
					title="Никого не найдено"
					subtitle="Попробуйте изменить поисковый запрос или зайти попозже"
					action-label="На главную"
					@click="router.visit(route('home'))"
				/>
				<div
					class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3"
					v-else
				>
					<InstructorCard
						v-for="instructor in props.instructors.data"
						:instructor="instructor"
						:key="instructor.id"
					/>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
