<script setup>
defineProps({
    images: Array
})
</script>

<template>
<div class="rounded-xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-2 gap-1 overflow-hidden">
    <div class="group overflow-hidden"
         :class="i === 0 ? 'row-span-2 col-span-2' : ''"
         v-for="(img,i) in images">
        <img :src="img.src" class="object-cover h-full transition cursor-pointer group-hover:scale-110" alt="">
    </div>
</div>
</template>

