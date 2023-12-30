<script setup>
	import { Link } from '@inertiajs/vue3'
	import InstructorModalSchedule from '@/Components/Instructors/InstructorModalSchedule.vue'

	const props = defineProps({
		instructor: {
			type: Object,
			required: true,
		},
	})
</script>

<template>
	<div class="group">
		<Link
			:href="
				route('instructors.view', {
					instructor: props.instructor.id,
				})
			"
			class="block h-72 overflow-hidden rounded-xl relative"
		>
			<img
				class="absolute inset-0 top-1/2 -translate-y-1/2 group-hover:scale-110 transition"
				:src="props.instructor.avatar.src"
				:srcset="props.instructor.avatar.srcset"
				:alt="props.instructor.name"
			/>
			<div
				v-if="props.instructor.description"
				class="absolute inset-0 bg-neutral-800/60 opacity-0 group-hover:opacity-100 transition text-white p-4 md:p-6 overflow-auto"
			>
				{{ props.instructor.description }}
			</div>
		</Link>
		<Link
			:href="
				route('instructors.view', {
					instructor: props.instructor.id,
				})
			"
			class="text-lg md:text-xl lg:text-2xl mt-6 block font-medium text-neutral-800"
			>{{ props.instructor.name }}</Link
		>
		<div class="font-light text-neutral-600">{{ props.instructor.type }}</div>

		<InstructorModalSchedule :instructor="props.instructor" />
	</div>
</template>
