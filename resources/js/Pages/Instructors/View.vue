<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import { onMounted, ref } from 'vue'
	import Container from '@/Components/Container.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import InstructorModalSchedule from '@/Components/Instructors/InstructorModalSchedule.vue'

	const props = defineProps({
		instructor: {
			type: Object,
		},
	})

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
		{
			id: 'instructor',
			route: route('instructors.list'),
			label: props.instructor.data.name,
		},
	])
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />

			<div class="flex gap-4 flex-col md:flex-row mt-6 md:mt-10">
				<div class="w-full">
					<div class="text-2xl font-semibold text-neutral-800">{{ props.instructor.data.name }}</div>
					<div class="font-light text-neutral-600">{{ props.instructor.data.type }}</div>
					<div v-if="props.instructor.data.description">{{ props.instructor.data.description }}</div>
					<InstructorModalSchedule :instructor="{ ...props.instructor.data }" />
				</div>
				<div class="w-full">
					<div class="rounded-lg overflow-hidden">
						<img
							class="w-full object-cover"
							:src="props.instructor.data.avatar.src"
							alt=""
						/>
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
