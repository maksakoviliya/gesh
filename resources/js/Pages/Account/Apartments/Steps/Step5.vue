<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import { ref } from 'vue'
	import Input from '@/Components/Input.vue'
	import Map from '@/Components/Map/Map.vue'
	import Counter from '@/Components/Counter.vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		guests: props.apartment.guests ?? 2,
		bedrooms: props.apartment.bedrooms ?? 1,
		beds: props.apartment.beds ?? 1,
		bathrooms: props.apartment.bathrooms ?? 1,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 5,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.id,
			})
		)
	}
</script>

<template>
	<Form
		:step="5"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.id,
					step: 4,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full">
			<Heading
				title="Основная информация о жилье"
				subtitle="Детали (например, типы кроватей) вы сможете добавить позже."
			/>
			<div class="grid grid-cols-1 gap-10 mt-10">
				<Counter
					v-model="form.guests"
					title="Гости"
					:error="form.errors.guests"
					@update:modelValue="form.clearErrors()"
					subtitle="Максимальное количество гостей"
				/>
				<Counter
					v-model="form.bedrooms"
					title="Спальни"
					:error="form.errors.bedrooms"
					@update:modelValue="form.clearErrors()"
					subtitle="Количество отдельных спален"
				/>
				<Counter
					v-model="form.beds"
					title="Кровати"
					:error="form.errors.beds"
					@update:modelValue="form.clearErrors()"
					subtitle="Количество отдельных кроватей"
				/>
				<Counter
					v-model="form.bathrooms"
					title="Ванные"
					:error="form.errors.bathrooms"
					@update:modelValue="form.clearErrors()"
					subtitle="Количество ванных комнат"
				/>
			</div>
		</div>
	</Form>
</template>
