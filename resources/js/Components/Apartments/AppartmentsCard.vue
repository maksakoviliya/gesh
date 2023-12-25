<script setup>
	import { router } from '@inertiajs/vue3'
	import Guests from '@/Components/Guests.vue'
	import Bedrooms from '@/Components/Bedrooms.vue'
	import Beds from '@/Components/Apartments/Beds.vue'
	import Bathrooms from '@/Components/Apartments/Bathrooms.vue'

	const props = defineProps({
		apartment: Object,
	})

	const handleClick = () => {
		return router.visit(route('apartment', props.apartment.id))
	}
</script>

<template>
	<div
		class="col-span-1 cursor-pointer group"
		@click="handleClick"
	>
		<div class="flex flex-col gap-2 w-full">
			<div class="aspect-square w-full relative overflow-hidden rounded-xl">
				<img
					class="object-cover h-full w-full group-hover:scale-110 transition"
					:src="props.apartment.media.length ? props.apartment.media[0]?.src : '/img/no-photo.jpeg'"
					:srcset="props.apartment.media.length ? props.apartment.media[0]?.srcset : null"
					:alt="props.apartment.title"
				/>
			</div>
			<!--            <div class="font-semibold text-lg">-->
			<!--                {location?.region}, {location?.label}-->
			<!--            </div>-->
			<div
				class="font-light text-neutral-500 dark:text-slate-300"
				:class="props.apartment.category ? '' : 'opacity-30'"
			>
				{{ props.apartment.category?.title ?? 'Нет типа' }}
			</div>
			<div class="flex flex-row items-center gap-1">
				<!--				<div class="font-semibold">-->
				<!--					{{ props.apartment.price.toLocaleString('ru') }}₽-->
				<!--					<span class="text-neutral-500 font-light text-sm">ночь</span>-->
				<!--				</div>-->
			</div>
			<div class="flex flex-row items-center justify-between gap-2">
				<Guests :guests="props.apartment.guests" />
				<Bedrooms :bedrooms="props.apartment.bedrooms" />
				<Beds :beds="props.apartment.beds" />
				<Bathrooms :bathrooms="props.apartment.bathrooms" />
			</div>
			<div class="text-neutral-400 dark:text-slate-400">
				<span class="font-bold text-xl text-neutral-800 dark:text-white">{{
					props.apartment.weekdays_price
				}}</span>
				₽ / ночь
			</div>
		</div>
	</div>
</template>
