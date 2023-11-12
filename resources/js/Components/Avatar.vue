<script setup>
defineProps({
    src: String
})
</script>

<template>
    <img
        class="rounded-full"
        height="30"
        width="30"
        alt="Avatar"
        :src="src ?? '/img/no-user.svg'"
    />
</template>

