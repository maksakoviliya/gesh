<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { useForm } from '@inertiajs/vue3'
	import Alert from '@/Components/Alerts/Alert.vue'

	const props = defineProps({
		categories: Array | Object,
		apartment: Array | Object,
	})

	const form = useForm({
		category_id: props.apartment.category_id,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 1,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.id,
			})
		)
	}

	const setActiveCategoryId = (id) => {
		form.category_id = id
		form.clearErrors('category')
	}
</script>

<template>
	<Form
		:step="1"
		@onNextStep="submit"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full">
			<Heading title="К какой категории относится ваше жилье?" />
			<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
				<div
					@click="setActiveCategoryId(category.id)"
					v-for="category in categories.data"
					:key="category.id"
					class="border-2 shadow-lg p-6 rounded-lg cursor-pointer hover:shadow-xl transition"
					:class="
						form.category_id === category.id
							? 'border-neutral-800 hover:border-neutral-800 bg-neutral-100'
							: 'border-neutral-50 hover:border-neutral-500'
					"
				>
					<div
						v-html="category.icon"
						class="text-neutral-800 w-10"
					></div>
					<div class="mt-4 font-semibold text-lg">{{ category.title }}</div>
				</div>
			</div>
			<transition name="fade">
				<Alert
					v-if="form.hasErrors"
					class="mt-8"
					:error="true"
					title="В форме есть ошибки"
					:subtitle="form.errors.category_id"
				/>
			</transition>
		</div>
	</Form>
</template>
