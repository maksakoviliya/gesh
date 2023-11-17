<script setup>
import vueFilePond from 'vue-filepond';

const props = defineProps({
    modelValue: {
        type: Array,
    },
    id: {
        type: String
    },
    error: {
        type: String
    }
})

const emit = defineEmits([
    'update:modelValue'
])

// Import plugins
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

// Import styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';


// Create FilePond component
const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

const handleFileAdd = (error, file) => {
    if (error) {
        console.log('Oh no');
        return;
    }

    emit('update:modelValue', [...props.modelValue, file.file])
    console.log('File added', file)
}
</script>

<template>
    <div>
    <FilePond store-as-file max-files="4" @addfile="handleFileAdd" :allow-multiple="true"
              :status="2" :labelIdle="`<div class='${!!error ? 'text-rose-500' : ''}'>Перетащите или <span class='underline font-medium'>выберите</span> изображения</div>`"/>
        <div v-if="!!error" class="text-rose-500 text-sm font-light">{{ error}}</div>
    </div>
</template>

<style>
.filepond--item {
    width: calc(25% - 0.5em);
}
</style>
