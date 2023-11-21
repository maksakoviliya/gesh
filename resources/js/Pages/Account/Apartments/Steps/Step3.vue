<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import { ref } from 'vue'
	import Input from '@/Components/Input.vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		state: props.apartment.state,
		city: props.apartment.city,
		street: props.apartment.street,
		building: props.apartment.building,
		housing: props.apartment.housing,
		room: props.apartment.room,
		floor: props.apartment.floor,
		entrance: props.apartment.entrance,
		index: props.apartment.index,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 3,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.id,
			})
		)
	}
</script>

<template>
	<Form
		:step="3"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.id,
					step: 2,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full">
			<Heading
				title="Подтвердите адрес"
				subtitle="Гости увидят адрес, только оформив бронирование."
			/>
			<div class="grid grid-cols-1 gap-2 mt-10">
				<Input
					id="state"
					v-model="form.state"
					label="Регион"
					:error="form.errors.state"
				/>
				<Input
					id="city"
					v-model="form.city"
					label="Город"
					:error="form.errors.city"
					:required="true"
				/>
				<Input
					id="street"
					v-model="form.street"
					label="Улица"
					:error="form.errors.street"
					:required="true"
				/>
				<div class="flex items-start gap-2">
					<Input
						id="building"
						v-model="form.building"
						label="Дом"
						:error="form.errors.building"
						:required="true"
					/>
					<Input
						id="housing"
						v-model="form.housing"
						label="Копус | Строение"
						:error="form.errors.housing"
					/>
				</div>
				<Input
					id="room"
					v-model="form.room"
					label="Квартира"
					:error="form.errors.room"
				/>
				<div class="flex items-start gap-2">
					<Input
						id="entrance"
						v-model="form.entrance"
						label="Подъезд"
						:error="form.errors.entrance"
					/>
					<Input
						id="floor"
						v-model="form.floor"
						label="Этаж"
						:error="form.errors.floor"
					/>
				</div>
				<Input
					id="index"
					v-model="form.index"
					label="Индекс"
					:error="form.errors.index"
				/>
			</div>
		</div>
	</Form>
</template>
