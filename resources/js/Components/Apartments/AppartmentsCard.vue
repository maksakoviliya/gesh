<script setup>
	import { Link } from '@inertiajs/vue3'
	import Guests from '@/Components/Guests.vue'
	import Bedrooms from '@/Components/Bedrooms.vue'
	import Beds from '@/Components/Apartments/Beds.vue'
	import Bathrooms from '@/Components/Apartments/Bathrooms.vue'
	import { Navigation, Pagination } from 'swiper/modules'
	import { Swiper, SwiperSlide } from 'swiper/vue'
	import 'swiper/css'
	import 'swiper/css/navigation'
	import { ref } from 'vue'
	import 'lazysizes'
	import IsVerified from '@/Components/Apartments/IsVerified.vue'
	import Price from '@/Components/Apartments/Price.vue'
	import TotalPrice from '@/Components/Apartments/TotalPrice.vue'

	const props = defineProps({
		apartment: Object,
	})

	const modules = ref([Navigation, Pagination])
</script>

<template>
	<div class="col-span-1 cursor-pointer group relative">
		<IsVerified v-if="props.apartment.is_verified" />
		<div class="flex flex-col gap-2 w-full h-full">
			<div class="aspect-square w-full flex relative overflow-hidden rounded-xl">
				<template v-if="props.apartment.media.length">
					<Swiper
						:modules="modules"
						:navigation="true"
					>
						<SwiperSlide
							v-for="image in props.apartment.media"
							:key="image.id"
						>
							<!--							<img-->
							<!--								loading="eager"-->
							<!--								@click="handleClick"-->
							<!--								class="object-cover h-full w-full"-->
							<!--                                content-visibility="auto"-->
							<!--                                decoding="async"-->
							<!--								:src="image.src"-->
							<!--								:srcset="image.srcset"-->
							<!--								:alt="props.apartment.title"-->
							<Link :to="route('apartment', props.apartment.id)">
								<img
									@click="handleClick"
									:alt="props.apartment.title"
									data-sizes="auto"
									:data-src="image.src"
									:data-srcset="image.srcset"
									class="lazyload object-cover h-full w-full"
								/>
							</Link>
						</SwiperSlide>
					</Swiper>
				</template>
				<Link
					:to="route('apartment', props.apartment.id)"
					v-else
				>
					<img
						class="object-cover h-full w-full"
						src="/img/no-photo.jpeg"
						:alt="props.apartment.title"
					/>
				</Link>
			</div>
			<Link
				:to="route('apartment', props.apartment.id)"
				class="font-semibold text-lg dark:text-slate-200"
			>
				{{ props.apartment.title ?? props.apartment.category?.title_single }}
				({{ props.apartment.city }})
			</Link>
			<Link
				:to="route('apartment', props.apartment.id)"
				class="font-light text-neutral-500 dark:text-slate-300"
				:class="props.apartment.category ? '' : 'opacity-30'"
			>
				{{ props.apartment.category?.title_single ?? 'Нет типа' }}
			</Link>

			<!--			<div class="flex flex-row items-center gap-1 mt-auto">-->
			<!--				<div class="font-semibold">-->
			<!--					{{ props.apartment.price.toLocaleString('ru') }}₽-->
			<!--					<span class="text-neutral-500 font-light text-sm">ночь</span>-->
			<!--				</div>-->
			<!--			</div>-->
			<Link
				:to="route('apartment', props.apartment.id)"
				class="flex flex-row items-center justify-between gap-2"
			>
				<Guests :guests="props.apartment.guests" />
				<Bedrooms :bedrooms="props.apartment.bedrooms" />
				<Beds :beds="props.apartment.beds" />
				<Bathrooms :bathrooms="props.apartment.bathrooms" />
			</Link>
			<TotalPrice
				v-if="props.apartment.total_price"
				:price="props.apartment.total_price"
			/>
			<Price :price="props.apartment.weekdays_price" />
		</div>
	</div>
</template>

<style>
	.swiper-button-prev.swiper-button-disabled,
	.swiper-button-next.swiper-button-disabled {
		@apply opacity-0 hidden;
	}
	.swiper-button-prev,
	.swiper-button-next {
		@apply aspect-square w-8 h-8 bg-white rounded-full hover:scale-110 transition cursor-pointer opacity-0 group-hover:opacity-100;
	}
	.swiper-button-prev:after,
	.swiper-button-next:after {
		@apply text-base text-blue-500;
	}
</style>
