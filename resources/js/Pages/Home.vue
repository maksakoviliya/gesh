<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Categories from "@/Components/Categories.vue";
import Container from "@/Components/Container.vue";

defineProps({
    categories: Array | null,
});
</script>

<template>
    <AppLayout>
        <Container>
            <Categories :categories="categories.data"/>
            Homepage
        </Container>
    </AppLayout>
</template>
