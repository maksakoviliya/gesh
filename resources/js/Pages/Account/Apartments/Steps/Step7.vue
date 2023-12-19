<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import FileInput from '@/Components/Inputs/FileInput.vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiX, MdSettingsbackuprestore } from 'oh-vue-icons/icons'

	addIcons(HiX, MdSettingsbackuprestore)

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		media: [],
		remove: [],
		current: props.apartment.data.media,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 7,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}

	const handleError = (error) => {
		form.setError('media', error)
	}

	const handleRemove = (id) => {
		if (!form.remove.includes(id)) {
			form.remove.push(id)
			return
		}
		form.remove.splice(form.remove.indexOf(id), 1)
	}
</script>

<template>
	<Form
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
				<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
					<div
						v-for="image in props.apartment.data.media"
						:key="image.id"
						class="aspect-video w-full relative group"
					>
						<img
							:src="image.src"
							alt=""
							class="object-cover object-center h-full w-full"
						/>
						<div
							class="absolute inset-0 bg-rose-400 opacity-20"
							v-if="form.remove.includes(image.id)"
						></div>
						<div
							@click="handleRemove(image.id)"
							class="absolute bg-sky-400 text-neutral-100 flex flex-col items-center justify-center rounded-full aspect-square w-8 h-8 top-2 right-2 scale-0 opacity-70 transition group-hover:scale-100 cursor-pointer hover:opacity-100"
						>
							<OhVueIcon
								:name="form.remove.includes(image.id) ? 'md-settingsbackuprestore' : 'hi-x'"
								scale="0.8"
							/>
						</div>
					</div>
				</div>
				<FileInput
					class="mt-8"
					id="media"
					v-model="form.media"
					:error="form.errors.media"
					:errors="form.errors"
					@error="handleError"
					@reset="form.clearErrors()"
				/>
			</div>
		</div>
	</Form>
</template>
