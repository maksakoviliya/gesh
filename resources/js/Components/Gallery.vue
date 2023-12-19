<script setup>
	import { computed } from 'vue'

	const props = defineProps({
		images: {
			type: Array,
			default: [],
		},
	})

	const imagesLimited = computed(() => {
		return props.images.slice(0, 4)
	})

	const getImageWrapperClasses = (index) => {
		let result = []
		if (index === 0) {
			result.push('row-span-2', imagesLimited.value.length <= 1 ? 'col-span-full' : 'col-span-2')
		}
		if (index === 1) {
			result.push(
				imagesLimited.value.length <= 3 ? 'row-span-2' : '',
				imagesLimited.value.length <= 2 ? 'col-span-2' : ''
			)
		}
		if (index === 2) {
			result.push(
				imagesLimited.value.length <= 4 ? 'row-span-2' : '',
				'row-span-2',
				imagesLimited.value.length <= 3 ? 'col-span-1' : ''
			)
		}
		return result.join(' ')
	}
</script>

<template>
	<div
		class="rounded-xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-2 md:max-h-72 gap-1 overflow-hidden"
	>
		<div
			class="group overflow-hidden"
			:class="getImageWrapperClasses(i)"
			v-for="(img, i) in imagesLimited"
		>
			<img
				:src="img.src"
				class="object-cover w-full h-full transition cursor-pointer group-hover:scale-110"
				alt=""
			/>
		</div>
	</div>
</template>
