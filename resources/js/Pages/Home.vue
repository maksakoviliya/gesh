<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Categories from "@/Components/Categories.vue";
import Container from "@/Components/Container.vue";
import Apartments from "@/Components/Apartments.vue";

defineProps({
    categories: Array | null,
    apartments: Array | null
});
</script>

<template>
    <AppLayout>
        <Container>
            <Categories :categories="categories.data"/>
            <Apartments :apartments="apartments"/>
        </Container>
    </AppLayout>
</template>
