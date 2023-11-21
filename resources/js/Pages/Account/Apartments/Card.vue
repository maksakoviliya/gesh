<script setup>
	import Rooms from '@/Components/Rooms.vue'
	import Guests from '@/Components/Guests.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import { router } from '@inertiajs/vue3'

	const props = defineProps({
		apartment: Object,
	})

	const handleClick = () => {
		return router.visit(
			route('account.apartments.step', {
				apartment: props.apartment.id,
				step: props.apartment.step,
			})
		)
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
					src="/img/no-photo.jpeg"
					:alt="props.apartment.title"
				/>
				<div class="absolute top-3 right-3">
					<!--                    <HeartButton-->
					<!--                        listingId={data.id}-->
					<!--                        currentUser={currentUser}-->
					<!--                    />-->
				</div>
			</div>
			<!--            <div class="font-semibold text-lg">-->
			<!--                {location?.region}, {location?.label}-->
			<!--            </div>-->
			<div class="font-light text-neutral-500">
				{{ props.apartment.categories.map((category) => category.title).join(', ') }}
			</div>
			<div class="flex flex-row items-center gap-1">
				<!--				<div class="font-semibold">-->
				<!--					{{ props.apartment.price.toLocaleString('ru') }}₽-->
				<!--					<span class="text-neutral-500 font-light text-sm">ночь</span>-->
				<!--				</div>-->
			</div>
			<div class="flex flex-row items-center gap-2">
				<Rooms :rooms="props.apartment.bedrooms" />
				<Guests :guests="props.apartment.guests" />
			</div>
			<!--            {onAction && actionLabel && (-->
			<ButtonComponent
				:small="true"
				label="Редактировать"
			/>
			<!--            )}-->
		</div>
	</div>
</template>
