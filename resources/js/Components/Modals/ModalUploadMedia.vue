<script setup lang="ts">
	import Modal from '@/Components/Modals/Modal.vue'
	import { useDropzone } from 'vue3-dropzone'
	import { reactive, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiTrash } from 'oh-vue-icons/icons'

	addIcons(HiTrash)

	const props = defineProps({
		isOpen: Boolean,
		url: String,
		title: {
			type: String,
			default: 'Загрузить фото',
		},
	})

	const emit = defineEmits(['onClose', 'onSubmit'])

	const previewUrls = ref([])

	const hasFiles = ref(false)

	const form = useForm({
		files: [],
	})

	const handleClose = () => {
		emit('onClose')
		hasFiles.value = false
		form.files = []
		previewUrls.value = []
	}

	const handleSubmit = () => {
		saveFiles()
	}

	const saveFiles = () => {
		form.post(props.url, {
			onSuccess: (res) => {
				emit('onSubmit')
				emit('onClose')
				hasFiles.value = false
				form.files = []
				previewUrls.value = []
			},
			preserveScroll: true,
		})
	}

	const previewFiles = (files: File[]): Promise<string[]> => {
		form.files = files
		let filesProcessed = 0

		if (files.length === 0) {
			console.error('no files')
			return
		}

		form.files.forEach((file) => {
			const reader = new FileReader()

			reader.onload = (event) => {
				if (event.target?.result) {
					previewUrls.value.push(event.target.result as string)
				}
				filesProcessed++
			}

			reader.onerror = (error) => {
				console.error(error)
				return
			}

			reader.readAsDataURL(file)
		})
	}

	function onDrop(acceptedFiles: File[], rejectReasons: FileRejectReason[]) {
		console.log('acceptedFiles', acceptedFiles)
		console.log('rejectReasons', rejectReasons)
		hasFiles.value = true
		previewFiles(acceptedFiles)
	}

	const options = reactive({
		multiple: true,
		onDrop,
	})

	const { getRootProps, getInputProps, isDragActive, isDragReject, open } = useDropzone(options)

	const removeFile = (index) => {
		form.files.splice(index, 1)
		previewUrls.value.splice(index, 1)
	}
</script>

<template>
	<Modal
		:is-open="props.isOpen"
		@onSecondaryAction="handleClose"
		@onClose="handleClose"
		@onSubmit="handleSubmit"
		:title="props.title"
		action-label="Загрузить"
		secondary-action-label="Отменить"
	>
		<template #body>
			<div
				class="w-full overflow-auto max-h-72"
				v-if="hasFiles"
			>
				<div class="grid grid-cols-2 gap-4">
					<div
						class="rounded-xl overflow-hidden relative aspect-square"
						v-for="(url, index) in previewUrls"
						:key="url"
					>
						<img
							class="w-full h-full object-cover"
							:src="url"
							alt=""
						/>
						<button
							type="button"
							@click="removeFile(index)"
							class="absolute top-3 right-3 rounded-full text-xs bg-rose-300 flex w-7 h-7 flex-col items-center justify-center hover:bg-rose-400 transition text-neutral-800"
						>
							<OhVueIcon name="hi-trash" />
						</button>
					</div>
				</div>
			</div>
			<div
				v-else
				v-bind="getRootProps()"
				:class="isDragActive ? 'bg-white bg-opacity-20' : ''"
				class="flex flex-col p-6 items-center justify-center border-2 border-dashed rounded-xl min-h-[230px]"
			>
				<input v-bind="getInputProps()" />
				<p>Перетащите файлы</p>
				<p>или</p>
				<button
					@click="open"
					class="underline cursor-pointer"
				>
					Выберите вручную
				</button>

				<div
					v-if="isDragReject"
					id="isDragReject"
				>
					isDragReject: {{ isDragReject }}
				</div>
			</div>
		</template>
	</Modal>
</template>
