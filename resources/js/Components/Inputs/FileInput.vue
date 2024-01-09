<script setup>
	import { ref } from 'vue'
	import vueFilePond from 'vue-filepond'

	const props = defineProps({
		modelValue: Array,
		id: String,
		error: String | null,
		errors: Array | null,
		url: String,
		name: {
			type: String,
			default: 'image',
		},
	})

	const initialFiles = props.modelValue
		.sort((a, b) => {
			return parseInt(a.order_column) - parseInt(b.order_column)
		})
		.map((item) => {
			console.log('item', item)
			return {
				source: item.id,
				options: {
					type: 'local',
					metadata: {
						order: item.order_column,
					},
				},
			}
		})

	const emit = defineEmits(['update:modelValue', 'error', 'reset'])

	// Import plugins
	import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
	import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
	import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'

	// Import styles
	import 'filepond/dist/filepond.min.css'
	import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
	import axios from 'axios'
	import { usePage } from '@inertiajs/vue3'

	// Create FilePond component
	const FilePond = vueFilePond(
		FilePondPluginFileValidateType,
		FilePondPluginImagePreview,
		FilePondPluginFileValidateSize
	)
	const pond = ref()

	const handleUpdateFiles = async (files) => {
		console.log('files', files)
		emit('update:modelValue', [...files.map((item) => item.serverId)])
		emit('reset')
	}

	const handleProcessFiles = async () => {
		const files = pond.value.getFiles()
		emit('update:modelValue', [...files.map((item) => item.serverId)])
		emit('reset')
	}

	const maxFiles = ref(20)

	const handleWarning = (error) => {
		console.log('Warning: ', error)
		emit('error', `Вы не можете загрузить больше ${maxFiles.value} файлов.`)
	}

	const handleReorder = (files, origin, target) => {
		handleUpdateFiles(files)
		// console.log('reorder')
	}

	const page = usePage()

	const handleRemove = (error, file) => {
		console.log('handleRemove error', error)
		console.log(' handleRemove file', file)
		// handleProcessFiles()
	}

	const beforeRemove = (item) => {
		console.log('beforeRemove item', item)
	}
</script>

<template>
	<div>
		<FilePond
			ref="pond"
			:name="props.name"
			:max-files="maxFiles"
			@processfile="handleProcessFiles"
			@warning="handleWarning"
			max-file-size="5MB"
			item-insert-location="after"
			:allow-multiple="true"
			:allow-reorder="true"
			:files="initialFiles"
			label-max-file-size-exceeded="Файл слишком большой"
			label-max-file-size="Максимальный размер {filesize}"
			@reorderfiles="handleReorder"
			@removefile="handleRemove"
			:before-remove-file="beforeRemove"
			:server="{
				process: {
					url: props.url,
				},
				headers: {
					'X-CSRF-TOKEN': page.props.csrf_token,
				},
				// remove: async (source, load) => {
				// 	console.log('source remove', source)
				// let fileKey = this.uploadedFileIndex[source] ?? null
				//
				// if (!fileKey) {
				//     return
				// }
				//
				// await deleteUploadedFileUsing(fileKey)
				//
				// load()
				// },
				load: async (source, load) => {
					console.log('load source', source)
					let response = await axios.get(
						route('media', {
							id: source,
						}),
						{
							responseType: 'blob',
						}
					)
					console.log('response', response)
					load(response.data)
				},
				// process: async (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
				// 	const response = await axios.post(props.url, {
				// 		[fieldName]: file,
				// 	})
				// 	console.log('response', response)
				// },
				remove: async (source, load) => {
					const response = await axios.post(
						route('account.apartments.media.remove', {
							apartment: page.props.apartment.data.id,
						}),
						{
							id: source,
						}
					)
					load()
				},
				revert: async (uniqueFileId, load) => {
					const response = await axios.post(
						route('account.apartments.media.remove', {
							apartment: page.props.apartment.data.id,
						}),
						{
							id: uniqueFileId,
						}
					)
					load()
				},
			}"
			:labelIdle="`<div class='${
				!!error ? 'text-rose-500' : ''
			}'>Перетащите или <span class='underline font-medium cursor-pointer'>выберите</span> изображения</div>`"
		/>
		<div
			v-if="!!errors"
			class="text-rose-500 text-sm font-light flex flex-col gap-1"
		>
			<div v-for="key in Object.keys(errors)">
				{{ errors[key] }}
			</div>
		</div>
	</div>
</template>

<style>
	.filepond--panel-root {
		background-color: transparent;
		border: 2px solid #d4d4d4;
	}

	.filepond--item {
		width: calc(50% - 0.5em);
	}

	/* error state color */
	[data-filepond-item-state*='error'] .filepond--item-panel,
	[data-filepond-item-state*='invalid'] .filepond--item-panel {
		background-color: #fb7185;
	}

	.filepond--drop-label {
		@apply dark:text-slate-200;
	}

	.filepond--credits {
		@apply dark:text-slate-500 dark:opacity-100;
	}
</style>
