<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Heading from "@/Components/Heading.vue";
import Form from "@/Pages/Account/Apartments/Form.vue";

const routes = ref([
    {
        id: 'account',
        route: route('account.index'),
        label: 'Аккаунт',
    },
    {
        id: 'apartments',
        route: route('account.apartments'),
        label: 'Объекты',
    },
    {
        id: 'apartments.create',
        route: route('account.apartments.create'),
        label: 'Создать',
    },
])
</script>

<template>
    <AppLayout>
        <Container :sm="true">
            <Breadcrumbs :routes="routes"/>
            <Heading
                class="mt-6"
                title="Добавить объект"
                subtitle="Как можно подробнее опишите объект, который вы хотите разместить"
            />

            <Form />

        </Container>
    </AppLayout>
</template>

