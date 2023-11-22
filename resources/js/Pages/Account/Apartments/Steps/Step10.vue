<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import TextareaInput from '@/Components/Inputs/TextareaInput.vue'
	import PriceInput from '@/Components/Inputs/PriceInput.vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		weekdays_price: props.apartment.data.weekdays_price ?? 2599,
		weekends_price: props.apartment.data.weekends_price ?? 2599,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 10,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}

	const handleUpdate = (value) => {
		if (!props.apartment.data.weekdays_price) {
			form.weekends_price = value
		}
	}
</script>

<template>
	<Form
		:step="10"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 9,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading
				title="Цена"
				subtitle="Ее можно изменить в любое время."
			/>
			<div class="mt-10 grid grid-cols-1 md:grid-cols-2">
				<div class="border-b md:border-b-0 md:border-r text-center md:pr-4">
					<PriceInput
						id="weekdays_price"
						v-model="form.weekdays_price"
						@update:modelValue="handleUpdate"
						label="в будни"
						:error="form.errors.weekdays_price"
					/>
				</div>
				<div class="text-center md:pl-4">
					<PriceInput
						id="weekends_price"
						v-model="form.weekends_price"
						label="в выходные"
						:error="form.errors.weekends_price"
					/>
				</div>
			</div>
		</div>
	</Form>
</template>
