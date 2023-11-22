<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import Input from '@/Components/Input.vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		title: props.apartment.data.title,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 8,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}
</script>

<template>
	<Form
		:step="8"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 7,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading
				title="Название жилья"
				subtitle="Это не обязательно. Вы всегда сможете добавить его позже"
			/>
			<div class="mt-10">
				<Input
					id="title"
					v-model="form.title"
					label="Название"
					:error="form.errors.title"
				/>
			</div>
		</div>
	</Form>
</template>
