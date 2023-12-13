<script setup>
import Container from '@/Components/Container.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { ref } from 'vue'
import Heading from '@/Components/Heading.vue'
import ButtonComponent from "@/Components/ButtonComponent.vue";

const props = defineProps({
    apartment: {
        type: Object
    }
})

const routes = ref([
    {
        id: 'account',
        route: route('account.index'),
        label: 'Аккаунт',
    },
    {
        id: 'apartments',
        route: route('account.apartments.list'),
        label: 'Объекты',
    },
    {
        id: 'apartment',
        route: route('account.apartments.edit', {
            apartment: props.apartment?.id
        }),
        label: 'Объект',
    },
])
</script>

<template>
    <AppLayout hidden-speed-dial>
        <Container :sm="true">
            <Breadcrumbs :routes="routes" />
            <div class="flex justify-between w-full items-center">
                <Heading
                    class="mt-6"
                    title="Редактировать объект"
                    subtitle="Управляйте своим объектом недвижимости"
                />
            </div>

            <div class="mt-10 flex flex-col gap-4">
                <slot></slot>
            </div>
            <div class="fixed inset-x-0 bottom-0 py-4 bg-white dark:bg-slate-800 border-t z-20">
                <Container :sm="true">
                    <div class="flex justify-between gap-6">
                        <ButtonComponent
                            :auto-width="true"
                            class="px-8"
                            :outline="true"
                            label="Назад"
                        />
                        <ButtonComponent
                            :auto-width="true"
                            class="px-8"
                            label="Далее"
                        />
                    </div>
                </Container>
            </div>
        </Container>
    </AppLayout>
</template>
