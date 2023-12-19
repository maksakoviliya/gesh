<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import { router, useForm } from '@inertiajs/vue3'

	const form = useForm({})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 12,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}

	const props = defineProps({
		apartment: Array | Object,
	})
</script>

<template>
	<Form
		:step="12"
		:edit="props.apartment.data.status === 'published'"
		@onNextStep="submit"
		:next-button-label="props.apartment.data.status === 'draft' ? 'Отправить на модерацию' : 'Далее'"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 11,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<div class="font-bold text-5xl">Почти готово</div>
			<div class="text-xl mt-4">
				<template v-if="props.apartment.data.status === 'draft'">
					Осталось отправить объявление отправлено на модерацию.
				</template>
				<template v-else> Дождитесь одобрения объявления. </template>
			</div>
		</div>
	</Form>
</template>
