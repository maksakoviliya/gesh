<script setup>
import Container from '@/Components/Container.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import {ref} from 'vue'
import Heading from '@/Components/Heading.vue'
import EmptyState from '@/Components/EmptyState.vue'
import {router} from '@inertiajs/vue3'
import ButtonComponent from '@/Components/ButtonComponent.vue'
import Card from '@/Pages/Account/Apartments/Card.vue'
import CardInList from "@/Pages/Account/Reservations/CardInList.vue";

defineProps({
    reservations: Object,
})

const routes = ref([
    {
        id: 'account',
        route: route('account.index'),
        label: 'Аккаунт',
    },
    {
        id: 'reservations',
        route: route('account.reservations.list'),
        label: 'Мои бронирования',
    },
])
</script>

<template>
    <AppLayout>
        <Container :sm="true">
            <Breadcrumbs :routes="routes"/>
            <Heading
                class="mt-6"
                title="Мои бронирования"
                subtitle="Управляйте своими бронированиями"
            />
            <EmptyState
                v-if="!reservations.data.length"
                title="Бронирований пока нет"
                subtitle="После выбора объекта он появится здесь для управления оплатой, отменой и тд."
            />
            <div
                v-else
                class="pt-4"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    <CardInList :reservation="reservation" v-for="reservation in reservations.data"/>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>
