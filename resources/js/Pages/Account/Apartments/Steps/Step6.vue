<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import { ref } from 'vue'
	import Input from '@/Components/Input.vue'
	import Map from '@/Components/Map/Map.vue'
	import Counter from '@/Components/Counter.vue'

	const props = defineProps({
		features: Array | Object,
		apartment: Array | Object,
	})

	const form = useForm({
		features: props.apartment.data.features.map((item) => item.id),
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 6,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}

	const onToggleFeature = (id) => {
		const index = form.features.findIndex((item) => item === id)
		if (index === -1) {
			form.features.push(id)
			return
		}
		form.features.splice(index, 1)
	}
</script>

<template>
	<Form
		:step="6"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 5,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading
				title="Преимущества вашего жилья"
				subtitle="Добавить другие удобства можно даже после публикации объявления."
			/>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10">
				<div
					class="border-2 shadow-lg p-4 rounded-lg cursor-pointer hover:shadow-xl transition"
					@click="onToggleFeature(feature.id)"
					v-for="feature in features.data"
					:class="
						form.features.includes(feature.id)
							? 'border-neutral-800 hover:border-neutral-800 bg-neutral-100'
							: 'border-neutral-50 hover:border-neutral-500'
					"
					:key="feature.id"
				>
					<div
						v-html="feature.icon"
						class="w-8"
					></div>
					<div class="font-semibold mt-2">{{ feature.title }}</div>
				</div>
			</div>
		</div>
	</Form>
</template>
