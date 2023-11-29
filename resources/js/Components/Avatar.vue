<script setup>
defineProps({
    src: String
})
</script>

<template>
    <img
        class="rounded-full w-[30px] h-[30px]"
        alt="Avatar"
        :src="src ?? '/img/no-user.svg'"
    />
</template>

