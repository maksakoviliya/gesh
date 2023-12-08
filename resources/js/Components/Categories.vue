<script setup>
	import CategoryBox from '@/Components/CategoryBox.vue'
	import { computed } from 'vue'
	import { usePage } from '@inertiajs/vue3'

	defineProps({
		categories: Array | null,
	})

	const page = usePage()
	const selectedCategory = computed(() => {
		const params = page.props.query
		return params['category'] ?? null
	})
</script>

<template>
	<div class="pt-4 flex flex-row items-center justify-between overflow-x-auto">
		<CategoryBox
			v-for="category in categories"
			:category="category"
			:selected="category.slug === selectedCategory"
			:key="category.id"
		/>
		<!--        {categories.map((item) => (-->
		<!--        <CategoryBox-->
		<!--            key={item.label}-->
		<!--            label={item.label}-->
		<!--            icon={item.icon}-->
		<!--            selected={category === item.label}-->
		<!--        />-->
		<!--        ))}-->
	</div>
</template>
