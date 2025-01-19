<script setup>
	import Guests from '@/Components/Guests.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import { router } from '@inertiajs/vue3'
	import Beds from '@/Components/Apartments/Beds.vue'
	import Bathrooms from '@/Components/Apartments/Bathrooms.vue'
	import Bedrooms from '@/Components/Bedrooms.vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiSolidLink, HiTrash } from 'oh-vue-icons/icons'
	import { onMounted, ref } from 'vue'
	import { initFlowbite } from 'flowbite'
	import ModalConfirmDeleting from '@/Components/Modals/ModalConfirmDeleting.vue'
	import Indicator from '@/Components/Interactive/Indicator.vue'

	onMounted(() => {
		initFlowbite()
	})

	addIcons(HiSolidLink, HiTrash)

	const props = defineProps({
		apartment: Object,
	})

	const handleClick = () => {
		return router.visit(
			route('account.apartments.step', {
				apartment: props.apartment.id,
				step: props.apartment.status !== 'published' ? props.apartment.step : 1,
			})
		)
	}

	const goToCalendar = (id) => {
		if (props.apartment.status === 'published') {
			return router.visit(
				route('account.apartments.calendar', {
					apartment: id,
				})
			)
		}
	}

	const goToChat = (id) => {
		if (props.apartment.status === 'published') {
			return router.visit(
				route('account.apartments.chats', {
					apartment: id,
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
			case 'published':
				return 'bg-green-300 text-neutral-900'
		}
	}

	const copyText = ref('Копировать ссылку')
	const handleCopy = (id) => {
		copyText.value = 'Скопировано'
		navigator.clipboard
			.writeText(
				route('apartment', {
					apartment: id,
				})
			)
			.then(() => {
				copyText.value = 'Скопировано'
				setTimeout(() => {
					copyText.value = 'Копировать ссылку'
				}, 1500)
			})
	}

	const isOpenDeleteModalConfirmation = ref(false)

	const deleteApartment = () => {
		router.visit(
			route('account.apartments.delete', {
				apartment: props.apartment.id,
			}),
			{
				method: 'post',
			}
		)
	}
</script>

<template>
	<div class="col-span-1 cursor-pointer group">
		<div class="flex flex-col gap-2 w-full">
			<div class="aspect-square w-full relative overflow-hidden rounded-xl">
				<img
					@click="handleClick"
					class="object-cover h-full w-full group-hover:scale-110 transition"
					:src="props.apartment.media.length ? props.apartment.media[0]?.src : '/img/no-photo.jpeg'"
					:alt="props.apartment.title"
				/>
				<div
					class="absolute top-3 end-3 px-2 rounded-full text-xs"
					:class="getStatusColor(props.apartment.status)"
				>
					{{ props.apartment.status_text }}
				</div>

				<div class="absolute top-3 start-3 opacity-0 group-hover:opacity-100 flex flex-col gap-2">
					<div
						v-if="props.apartment.status === 'published'"
						:data-tooltip-target="`link_${props.apartment.id}`"
						@click="handleCopy(props.apartment.id)"
						class="px-2 rounded-full text-xs w-8 h-8 aspect-square flex flex-col items-center justify-center bg-neutral-100 text-neutral-800 hover:bg-white transition dark:hover:bg-slate-800 dark:hover:text-slate-100"
					>
						<OhVueIcon name="hi-solid-link" />
					</div>
					<div
						:id="`link_${props.apartment.id}`"
						role="tooltip"
						class="absolute z-20 break-words whitespace-nowrap invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
					>
						{{ copyText }}
						<div
							class="tooltip-arrow"
							data-popper-arrow
						></div>
					</div>

					<div
						@click="isOpenDeleteModalConfirmation = true"
						:data-tooltip-target="`delete_${props.apartment.id}`"
						class="rounded-full text-xs bg-rose-300 flex w-7 h-7 flex-col items-center justify-center hover:bg-rose-400 transition text-neutral-800"
					>
						<OhVueIcon name="hi-trash" />
					</div>
					<div
						:id="`delete_${props.apartment.id}`"
						role="tooltip"
						class="absolute z-20 break-words whitespace-nowrap invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
					>
						Удалить объект
						<div
							class="tooltip-arrow"
							data-popper-arrow
						></div>
					</div>
				</div>
			</div>
			<div
				class="font-light text-neutral-500 dark:text-slate-400"
				:class="props.apartment.category ? '' : 'opacity-30'"
			>
				{{ props.apartment.category?.title ?? 'Нет типа' }}
			</div>
			<div class="flex flex-row items-center gap-1">
				<span class="text-neutral-500 dark:text-slate-500 leading-none font-light text-sm">
					{{ props.apartment.address }}
				</span>
			</div>
			<div class="flex flex-row items-center justify-between gap-2">
				<Guests :guests="props.apartment.guests" />
				<Bedrooms :bedrooms="props.apartment.bedrooms" />
				<Beds :beds="props.apartment.beds" />
				<Bathrooms :bathrooms="props.apartment.bathrooms" />
			</div>
			<ButtonComponent
				:small="true"
				@click="handleClick"
				:label="'Редактировать'"
			/>
		</div>

		<ModalConfirmDeleting
			:is-open="isOpenDeleteModalConfirmation"
			@onSubmit="deleteApartment"
			@onClose="isOpenDeleteModalConfirmation = false"
		/>
	</div>
</template>
