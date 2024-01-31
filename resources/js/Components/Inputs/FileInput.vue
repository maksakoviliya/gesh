<script setup>
	// Import Vue FilePond
	import vueFilePond from 'vue-filepond'
	import FilePondPluginFilePoster from 'filepond-plugin-file-poster'
	import FilePondPluginImageEditor from '@pqina/filepond-plugin-image-editor'

	// Import FilePond styles
	import 'filepond/dist/filepond.min.css'
	import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.css'

	// Import Pintura styles
	import '@pqina/pintura/pintura.css'

	// Import Pintura
	import {
		// editor
		createDefaultImageReader,
		createDefaultImageWriter,
		locale_en_gb,

		// plugins
		setPlugins,
		plugin_crop,
		plugin_crop_locale_en_gb,
		plugin_filter,
		plugin_filter_defaults,
		plugin_filter_locale_en_gb,
		plugin_finetune,
		plugin_finetune_defaults,
		plugin_finetune_locale_en_gb,
		plugin_annotate,
		plugin_annotate_locale_en_gb,
		markup_editor_defaults,
		markup_editor_locale_en_gb,

		// filepond
		openEditor,
		processImage,
		createDefaultImageOrienter,
		legacyDataToImageState,
	} from '@pqina/pintura'
	import { ref } from 'vue'
	import axios from 'axios'
	import { usePage } from '@inertiajs/vue3'

	setPlugins(plugin_crop, plugin_finetune, plugin_filter)

	const page = usePage()

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

	// Create FilePond component
	const FilePond = vueFilePond(FilePondPluginImageEditor, FilePondPluginFilePoster)

	const handleLoad = (event) => {
		console.log('load', event.detail)
	}
	const handleProcess = (event) => {
		console.log('process', event.detail)
		this.result = URL.createObjectURL(event.detail.dest)
	}
	const handleFilePondInit = () => {
		console.log('init')
	}

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

	import locale_ru_RU from '@pqina/pintura/locale/ru_RU'
	import plugin_crop_locale_ru_RU from '@pqina/pintura/locale/ru_RU'
	import markup_editor_locale_ru_RU from '@pqina/pintura/locale/ru_RU'

	const myEditor = ref({
		// map legacy data objects to new imageState objects
		legacyDataToImageState: legacyDataToImageState,

		// used to create the editor, receives editor configuration, should return an editor instance
		createEditor: openEditor,

		// Required, used for reading the image data
		imageReader: [createDefaultImageReader],

		// optionally. can leave out when not generating a preview thumbnail and/or output image
		imageWriter: [createDefaultImageWriter],

		// used to generate poster images, runs an editor in the background
		imageProcessor: processImage,

		// editor options
		editorOptions: {
			utils: ['crop', 'finetune', 'filter'],
			imageOrienter: createDefaultImageOrienter(),
			...plugin_finetune_defaults,
			...plugin_filter_defaults,
			...markup_editor_defaults,
			locale: {
				...plugin_finetune_locale_en_gb,
				...plugin_filter_locale_en_gb,
				...plugin_annotate_locale_en_gb,
				...locale_ru_RU,
				...plugin_crop_locale_ru_RU,
				...markup_editor_locale_ru_RU,
			},
		},
	})

	const emit = defineEmits(['update:modelValue', 'error', 'reset'])

	const pond = ref()

	const handleProcessFiles = async () => {
		const files = pond.value.getFiles()
		console.log('handleProcessFiles', files)
		// console.log(URL.createObjectURL(event.detail.dest))
		emit('update:modelValue', [...files.map((item) => item.serverId)])
		emit('reset')
	}
</script>

<template>
	<div>
		<FilePond
			ref="pond"
			:name="props.name"
			acceptedFileTypes="image/jpeg, image/png"
			@processfile="handleProcessFiles"
			allow-multiple="true"
			:imageEditor="myEditor"
			:files="initialFiles"
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
		/>
	</div>
</template>

<style>
	/* bright / dark mode */
	.pintura-editor {
		--color-background: 255, 255, 255;
		--color-foreground: 10, 10, 10;
		box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
	}

	@media (prefers-color-scheme: dark) {
		html {
			color: #fff;
			background: #111;
		}

		.pintura-editor {
			--color-background: 10, 10, 10;
			--color-foreground: 255, 255, 255;
			box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.1);
		}
	}

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
