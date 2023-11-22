<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import TextareaInput from '@/Components/Inputs/TextareaInput.vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		description: props.apartment.data.description,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 9,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}
</script>

<template>
	<Form
		:step="9"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 8,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading
				title="Описание жилья"
				subtitle="Это не обязательно. Вы всегда сможете добавить описание позже"
			/>
			<div class="mt-10">
				<TextareaInput
					id="description"
					v-model="form.description"
					label="Описание"
					:error="form.errors.description"
				/>
			</div>
		</div>
	</Form>
</template>
