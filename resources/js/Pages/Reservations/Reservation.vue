<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/Container.vue'
import Heading from "@/Components/Heading.vue";

const props = defineProps({
    reservation: {
        type: Object,
    }
})

</script>

<template>
    <AppLayout>
        <Container>
            <Heading title="Reservation"/>
        </Container>
    </AppLayout>
</template>
