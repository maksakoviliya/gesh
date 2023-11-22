<script setup>
	import Rooms from '@/Components/Bedrooms.vue'
	import Guests from '@/Components/Guests.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import { router } from '@inertiajs/vue3'
	import Beds from '@/Components/Apartments/Beds.vue'
	import Bathrooms from '@/Components/Apartments/Bathrooms.vue'
	import Bedrooms from '@/Components/Bedrooms.vue'

	const props = defineProps({
		apartment: Object,
	})

	const handleClick = () => {
		if (props.apartment.status === 'draft') {
			return router.visit(
				route('account.apartments.step', {
					apartment: props.apartment.id,
					step: props.apartment.step,
				})
			)
		}
	}

	const getStatusColor = (status) => {
		switch (status) {
			case 'draft':
				return 'bg-zinc-100 text-neutral-800'
			case 'pending':
				return 'bg-sky-100 text-neutral-800'
		}
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
					:alt="props.apartment.title"
				/>
				<div
					class="absolute top-3 right-3 px-2 rounded-full text-xs"
					:class="getStatusColor(props.apartment.status)"
				>
					{{ props.apartment.status_text }}
				</div>
			</div>
			<!--            <div class="font-semibold text-lg">-->
			<!--                {location?.region}, {location?.label}-->
			<!--            </div>-->
			<div
				class="font-light text-neutral-500"
				:class="props.apartment.categories.length ? '' : 'opacity-30'"
			>
				{{
					props.apartment.categories.length
						? props.apartment.categories.map((category) => category.title).join(', ')
						: 'Нет типа'
				}}
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
			<ButtonComponent
				:small="true"
				:disabled="props.apartment.status !== 'draft'"
				:label="props.apartment.status === 'draft' ? 'Редактировать' : 'На модерации'"
			/>
		</div>
	</div>
</template>
