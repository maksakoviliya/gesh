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
		features: props.apartment.features ?? [],
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 6,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.id,
			})
		)
	}
</script>

<template>
	<Form
		:step="6"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.id,
					step: 5,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full">
			<Heading
				title="Преимущества вашего жилья"
				subtitle="Добавить другие удобства можно даже после публикации объявления."
			/>
			<div class="grid grid-cols-1 gap-10 mt-10"></div>
		</div>
	</Form>
</template>
