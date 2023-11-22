<script setup>
	import vueFilePond from 'vue-filepond'
	import { ref } from 'vue'

	const props = defineProps({
		modelValue: Array,
		id: String,
		error: String | null,
		errors: Array | null,
	})

	const emit = defineEmits(['update:modelValue', 'error', 'reset'])

	// Import plugins
	import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
	import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

	// Import styles
	import 'filepond/dist/filepond.min.css'
	import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'

	// Create FilePond component
	const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview)
	const pond = ref()
	// const handleFileAdd = (error, file) => {
	// 	if (error) {
	// 		console.log('Oh no')
	// 		return
	// 	}
	//
	// 	emit('update:modelValue', [...props.modelValue, file.file])
	// 	emit('reset')
	// }

	// watch(
	// 	() => props.errors,
	// 	(value) => {
	// 		Object.keys(Object.assign({}, value)).forEach((item, index) => {
	// 			pond.value
	// 				.processFile(index)
	// 				.then((file) => {
	// 					// File has been processed
	// 					console.log('file', file)
	// 				})
	// 				.catch((err) => {
	// 					console.log('err', err)
	// 				})
	// 		})
	// 	},
	// 	{ deep: true }
	// )

	const handleUpdateFiles = (files) => {
		let result = files.map((item) => item.file)
		emit('update:modelValue', [...result])
		emit('reset')
	}

	const maxFiles = ref(10)
	// const handleError = (error, file) => {
	// 	console.log('error: ' + error)
	// 	console.log('file: ' + file)
	// }
	const handleWarning = (error) => {
		console.log('Warning: ', error)
		emit('error', `Вы не можете загрузить больше ${maxFiles.value} файлов.`)
	}
</script>

<template>
	<div>
		<FilePond
			ref="pond"
			store-as-file
			:max-files="maxFiles"
			@updatefiles="handleUpdateFiles"
			@warning="handleWarning"
			:allow-multiple="true"
			:labelIdle="`<div class='${
				!!error ? 'text-rose-500' : ''
			}'>Перетащите или <span class='underline font-medium'>выберите</span> изображения</div>`"
		/>
		<div
			v-if="!!error"
			class="text-rose-500 text-sm font-light"
		>
			{{ error }}
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
</style>
