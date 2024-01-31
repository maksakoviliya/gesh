<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import FileInput from '@/Components/Inputs/FileInput.vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiX, MdSettingsbackuprestore } from 'oh-vue-icons/icons'
	import { ref } from 'vue'

	addIcons(HiX, MdSettingsbackuprestore)

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		media: props.apartment.data.media,
	})

	const formComponent = ref()

	const submit = () => {
		formComponent.value.startLoading()
		form.transform((data) => ({
			...data,
			step: 7,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			}),
			{
				onFinish() {
					formComponent?.value?.stopLoading()
				},
			}
		)
	}

	const handleError = (error) => {
		form.setError('media', error)
	}
</script>

<template>
	<Form
		ref="formComponent"
		:step="7"
		@onNextStep="submit"
		:edit="props.apartment.data.status === 'published'"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 6,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-2xl mx-auto w-full pb-32">
			<Heading
				title="Загрузите фотографии"
				subtitle="Выберите фотографии, которые лучше всего покажут ваше жилье."
			/>
			<div class="mt-10">
				<FileInput
					v-model="form.media"
					class="mt-8"
					id="media"
					:error="form.errors.media"
					:errors="form.errors"
					@error="handleError"
					@reset="form.clearErrors()"
					:url="
						route('account.apartments.media.store', {
							apartment: apartment.data.id,
						})
					"
				/>
			</div>
		</div>
	</Form>
</template>
