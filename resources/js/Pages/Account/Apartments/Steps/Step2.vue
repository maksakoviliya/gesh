<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import Alert from '@/Components/Alerts/Alert.vue'

	const props = defineProps({
		types: Array | Object,
		apartment: Array | Object,
	})

	const form = useForm({
		type: props.apartment.data.type,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 2,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}

	const setActiveTypeId = (id) => {
		form.type = id
		form.clearErrors('type')
	}
</script>

<template>
	<Form
		:step="2"
		@onNextStep="submit"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 1,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading title="К какой категории относится ваше жилье?" />
			<div class="grid grid-cols-1 gap-8 mt-10">
				<div
					@click="setActiveTypeId(type.id)"
					v-for="type in types"
					:key="type.id"
					class="border-2 shadow-lg p-6 rounded-lg cursor-pointer hover:shadow-xl transition"
					:class="
						form.type === type.id
							? 'border-neutral-800 hover:border-neutral-800 bg-neutral-100'
							: 'border-neutral-50 hover:border-neutral-500'
					"
				>
					<div class="font-semibold text-lg">{{ type.title }}</div>
					<div class="font-light text-neutral-500 mt-1">{{ type.subtitle }}</div>
				</div>
			</div>
			<transition name="fade">
				<Alert
					v-if="form.hasErrors"
					class="mt-8"
					:error="true"
					title="В форме есть ошибки"
					:subtitle="form.errors.type"
				/>
			</transition>
		</div>
	</Form>
</template>
