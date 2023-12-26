<script setup>
	import { computed, ref } from 'vue'

	import CustomModal from '@/Components/Modals/CustomModal.vue'
	import FullScreenModal from '@/Components/Modals/FullScreenModal.vue'
	import { Swiper, SwiperSlide, useSwiper } from 'swiper/vue'
	import 'swiper/css'
	import { Navigation } from 'swiper/modules'
	import 'swiper/css/navigation'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiChevronLeft, HiChevronRight } from 'oh-vue-icons/icons'
	addIcons(HiChevronLeft, HiChevronRight)

	const props = defineProps({
		images: {
			type: Array,
			default: [],
		},
	})

	const imagesLimited = computed(() => {
		return props.images.slice(0, 5)
	})

	const getImageWrapperClasses = (index) => {
		switch (imagesLimited.value.length) {
			case 1:
				return 'row-span-2 col-span-full max-h-[600px]'
			case 2:
				return 'row-span-2 col-span-2 max-h-[600px]'
			case 3:
				return index === 0 ? 'row-span-2 col-span-2 ' : 'col-span-2'
			case 4:
				return 'row-span-2 col-span-1'
			case 5:
				return index === 0 ? 'row-span-2 col-span-2' : ''
		}
	}

	const isOpen = ref(false)

	const slideIndex = ref(null)

	const handleClose = () => {
		slideIndex.value = null
	}

	const handleCloseGallery = () => {
		isOpen.value = false
	}

	const handleShowGallery = (index) => {
		slideIndex.value = index
	}

	const initSwiper = (swiper) => {
		swiper.slideTo(slideIndex.value)
	}
</script>

<template>
	<div class="rounded-xl grid grid-cols-2 lg:grid-cols-4 grid-rows-2 gap-1 overflow-hidden">
		<div
			@click="isOpen = true"
			class="group overflow-hidden"
			:class="getImageWrapperClasses(i)"
			v-for="(img, i) in imagesLimited"
		>
			<img
				:src="img.src"
				:srcset="img.srcset"
				class="object-cover w-full h-full transition cursor-pointer group-hover:scale-110"
				alt=""
			/>
		</div>

		<CustomModal
			key="gallery"
			:is-open="isOpen"
			@close="handleCloseGallery"
		>
			<div class="grid gap-4 grid-cols-1 md:grid-cols-2">
				<div
					class="cursor-pointer md:[&:nth-child(3n)]:col-span-2"
					v-for="(image, index) in props.images"
					:key="image.id"
					@click="handleShowGallery(index)"
				>
					<img
						class="w-full h-full object-cover"
						:srcset="image.srcset"
						:src="image.src"
						alt=""
					/>
				</div>
			</div>

			<FullScreenModal
				key="slider"
				:is-open="slideIndex !== null"
				@close="handleClose"
			>
				<div class="w-full h-full flex items-center gap-4 justify-between p-6">
					<div
						id="swiper_prev"
						class="aspect-square w-6 md:w-16 h-6 md:h-16 hover:bg-gray-200 flex flex-col items-center justify-center rounded-full bg-gray-100 cursor-pointer"
					>
						<OhVueIcon
							name="hi-chevron-left"
							scale="1.6"
						/>
					</div>
					<Swiper
						@swiper="initSwiper"
						:auto-height="true"
						:slides-per-view="1"
						:modules="[Navigation]"
						:navigation="{
							prevEl: '#swiper_prev',
							nextEl: '#swiper_next',
							disabledClass: 'opacity-0 pointer-events-none',
						}"
					>
						<SwiperSlide v-for="slide in props.images">
							<img
								:srcset="slide.srcset"
								class="h-full w-auto object-cover mx-auto max-h-[90vh]"
								:src="slide.src"
								alt=""
							/>
						</SwiperSlide>
					</Swiper>
					<div
						id="swiper_next"
						class="aspect-square w-6 md:w-16 h-6 md:h-16 hover:bg-gray-200 flex flex-col items-center justify-center rounded-full bg-gray-100 cursor-pointer"
					>
						<OhVueIcon
							name="hi-chevron-right"
							scale="1.6"
						/>
					</div>
				</div>
			</FullScreenModal>
		</CustomModal>
	</div>
</template>
