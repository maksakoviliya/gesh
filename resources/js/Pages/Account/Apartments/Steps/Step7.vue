<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import Heading from '@/Components/Heading.vue'
	import { router, useForm, usePage } from '@inertiajs/vue3'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiX, MdSettingsbackuprestore, HiTrash, HiPlusSm } from 'oh-vue-icons/icons'
	import { onMounted, ref } from 'vue'
	import { VueDraggable } from 'vue-draggable-plus'
	import ModalConfirmDeleting from '@/Components/Modals/ModalConfirmDeleting.vue'
	import axios from 'axios'
	import useToasts from '@/hooks/useToasts'
	import ModalUploadMedia from '@/Components/Modals/ModalUploadMedia.vue'

	addIcons(HiX, MdSettingsbackuprestore, HiTrash, HiPlusSm)

	const props = defineProps({
		apartment: Array | Object,
	})
	const page = usePage()
	const form = useForm({
		media: page.props.apartment.data.media,
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

	const deletingPhotoId = ref(null)

	const { infoToast, errorToast } = useToasts()
	const deletePhoto = async () => {
		const response = await axios.post(
			route('account.apartments.media.remove', {
				apartment: props.apartment.data.id,
			}),
			{
				id: deletingPhotoId.value,
			}
		)
		if (response?.data?.success) {
			form.media.splice(
				form.media.findIndex((item) => item.id === deletingPhotoId.value),
				1
			)
			deletingPhotoId.value = null
			infoToast('Фото удалено!')
			return
		}

		errorToast('Возникла ошибка! Попробуйте повторить попозже...')
	}

	const isOpenModalUploadPhoto = ref(false)

	const onPhotosUploaded = () => {
		form.media = page.props.apartment.data.media
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
			<div class="flex flex-col md:flex-row gap-6 items-center justify-between">
				<Heading
					title="Загрузите фотографии"
					subtitle="Выберите фотографии, которые лучше всего покажут ваше жилье."
				/>
				<button
					type="button"
					@click="isOpenModalUploadPhoto = true"
					class="w-12 aspect-square border-2 rounded-full text-neutral-500 border-neutral-500 hover:border-neutral-800 hover:text-neutral-800 transition dark:border-slate-600 dark:text-slate-600 dark:hover:border-slate-300 dark:hover:text-slate-300"
				>
					<OhVueIcon
						name="hi-plus-sm"
						scale="1.4"
					/>
				</button>
				<ModalUploadMedia
					:is-open="isOpenModalUploadPhoto"
					@onClose="isOpenModalUploadPhoto = false"
					@onSubmit="onPhotosUploaded"
					:url="
						route('account.apartments.media.store', {
							apartment: apartment.data.id,
						})
					"
				/>
			</div>
			<VueDraggable
				class="mt-10 grid grid-cols-2 md:grid-cols-3 gap-4"
				ref="el"
				v-model="form.media"
			>
				<div
					class="w-full aspect-square relative cursor-grab active:cursor-grabbing"
					v-for="item in form.media"
					:key="item.id"
				>
					<img
						class="rounded-xl w-full h-full object-cover"
						:src="item.src"
						:alt="item.id"
					/>
					<div class="absolute top-3 right-3">
						<div>
							<button
								type="button"
								@click="deletingPhotoId = item.id"
								:data-tooltip-target="`delete_${item.id}`"
								class="rounded-full text-xs bg-rose-300 flex w-7 h-7 flex-col items-center justify-center hover:bg-rose-400 transition text-neutral-800"
							>
								<OhVueIcon name="hi-trash" />
							</button>
							<div
								:id="`delete_${item.id}`"
								role="tooltip"
								class="absolute z-20 break-words whitespace-nowrap invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
							>
								Удалить фото
								<div
									class="tooltip-arrow"
									data-popper-arrow
								></div>
							</div>
						</div>
					</div>
				</div>
			</VueDraggable>
		</div>

		<ModalConfirmDeleting
			:is-open="!!deletingPhotoId"
			@onSubmit="deletePhoto"
			@onClose="deletingPhotoId = null"
			title="Удалить фото"
		>
			<Heading
				title="Вы уверены что хотите удалить фото?"
				subtitle="Восстановить его не получится."
			/>
		</ModalConfirmDeleting>
	</Form>
</template>
