<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Gallery from '@/Components/Gallery.vue'
	import Heading from '@/Components/Heading.vue'
	import { computed } from 'vue'
	import Calendar from '@/Components/Calendar.vue'
	import Counter from '@/Components/Counter.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'

	const props = defineProps({
		apartment: Array | Object,
	})
</script>

<template>
	<AppLayout>
		<Container>
			<div
				v-if="props.apartment.data.address"
				class="text-3xl font-semibold"
			>
				{{ props.apartment.data.address }}
			</div>
			<Gallery
				class="mt-6"
				:images="apartment.data.images"
			/>
			<div class="flex flex-col items-start md:flex-row gap-6 justify-between mt-6 relative">
				<div class="w-full">
					<Heading
						:title="props.apartment.data.title ?? 'Тут название квартиры'"
						:subtitle="'subtitle'"
					/>
					<hr class="my-4" />
					<div class="text-xl">
						{{ props.apartment.data.category?.title }}
					</div>
					<hr class="my-4" />
					<div class="mt-6">
						{{ props.apartment.data.description ?? 'Тут описание квартиры' }}
					</div>
				</div>
				<div class="md:sticky rounded-lg shadow-lg border border-neutral-100 md:w-7/12 lg:1/3 top-28 p-6">
					<div class="text-2xl font-semibold">
						{{ props.apartment.data.weekdays_price?.toLocaleString('ru') }}₽
						<span class="text-neutral-500 font-light text-sm">ночь</span>
					</div>
					<div class="mt-4">
						<Calendar range />
						<Counter
							class="mt-4"
							title="Гости"
							subtitle="Укажите количество гостей"
						/>
						<Counter
							class="mt-4"
							title="Дети"
							subtitle="2-12 лет"
						/>
						<Counter
							class="mt-4"
							title="Младенцы"
							subtitle="До 2-х лет"
						/>
					</div>
					<hr class="my-4" />
					<ButtonComponent label="Забронировать" />
					<div class="font-light text-sm text-center mt-3 text-neutral-500">Пока вы ни за что не платите</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
