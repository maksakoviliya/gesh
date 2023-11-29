<script setup>
const props = defineProps({
    images: {
        type: Array,
        default: []
    }
})

const getImageWrapperClasses = (index) => {
    let result = [];
    if (index === 0) {
        result.push('row-span-2', props.images.length === 1 ? 'col-span-full' : 'col-span-2')
    }
    return result.join(' ')
}
</script>

<template>
    <div
        class="rounded-xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-2 md:max-h-72 gap-1 overflow-hidden">
        <div class="group overflow-hidden"
             :class="getImageWrapperClasses(i)"
             v-for="(img,i) in images">
            <img :src="img.src" class="object-cover w-full h-full transition cursor-pointer group-hover:scale-110"
                 alt="">
        </div>
    </div>
</template>

