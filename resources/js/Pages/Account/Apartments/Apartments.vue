<script setup>
import Container from '@/Components/Container.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import {ref} from 'vue'
import Heading from '@/Components/Heading.vue'
import EmptyState from "@/Components/EmptyState.vue";
import {router} from "@inertiajs/vue3";
import AppartmentsCard from "@/Components/AppartmentsCard.vue";
import ButtonComponent from "@/Components/ButtonComponent.vue";

defineProps({
    apartments: Array | Object
})

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
])

const add = () => {
    router.visit(route('account.apartments.create'))
}
</script>

<template>
    <AppLayout>
        <Container :sm="true">
            <Breadcrumbs :routes="routes"/>
            <div class="flex justify-between w-full items-center">
                <Heading
                    class="mt-6"
                    title="Добавить объект"
                    subtitle="Управляйте своими объектами недвижимости"
                />
                <div class="w-40">
                    <ButtonComponent bg-class="bg-emerald-600" @click="add" border-class="border-emerald-600" label="Добавить" />
                </div>
            </div>
            <EmptyState v-if="!apartments.data.length" title="Объектов пока нет"
                        subtitle="Добавьте ваш объект для того чтобы он стал виден всем"
                        action-label="Добавить" @onClick="add"/>
            <div v-else class="pt-4
            grid
            grid-cols-1
            sm:grid-cols-2
            md:grid-cols-3
            lg:grid-cols-4
            xl:grid-cols-5
            2xl:grid-cols-6
            gap-8">
                <AppartmentsCard
                    v-for="apartment in apartments.data"
                    :key="apartment.id"
                    :apartment="apartment"/>
            </div>
        </Container>
    </AppLayout>
</template>
