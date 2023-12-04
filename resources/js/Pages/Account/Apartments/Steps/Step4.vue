<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import { ref } from 'vue'
	import Input from '@/Components/Input.vue'
	import Map from '@/Components/Map/Map.vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		lon: props.apartment.data.lon ?? 87.98709856259356,
		lat: props.apartment.data.lat ?? 52.92596754124867,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 4,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}

	const onUpdateLon = (value) => {
		form.lon = value
	}
	const onUpdateLat = (value) => {
		form.lat = value
	}
</script>

<template>
	<Form
		:step="4"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 3,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading
				title="Уточните адрес"
				subtitle="Проверьте что указанный вами адрес верно отобразился на карте."
			/>
			<div class="mt-10">
				<Map
					:lon="form.lon"
					:lat="form.lat"
					@updateLon="onUpdateLon"
					@updateLat="onUpdateLat"
				/>
			</div>
		</div>
	</Form>
</template>
