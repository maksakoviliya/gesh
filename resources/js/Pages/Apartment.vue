<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/Container.vue'
import Gallery from '@/Components/Gallery.vue'
import Heading from '@/Components/Heading.vue'
import {computed, ref} from 'vue'
import Calendar from '@/Components/Calendar.vue'
import Counter from '@/Components/Counter.vue'
import ButtonComponent from '@/Components/ButtonComponent.vue'
import Avatar from "@/Components/Avatar.vue";
import {router, useForm} from "@inertiajs/vue3";
import dayjs from 'dayjs'
import {Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'

const props = defineProps({
    apartment: Array | Object,
})

const getTitle = () => {
    const category = [
        props.apartment.data.category?.title,
        props.apartment.data.title ?? null,
        props.apartment.data.city,
    ]
    return category.filter(item => !!item).join(', ')
}

const getSubtitle = () => {
    const result = [
        `${props.apartment.data.guests} гостей`,
        `${props.apartment.data.bedrooms} спальня`,
        `${props.apartment.data.beds} кровать`,
        `${props.apartment.data.bathrooms} ванная`,
    ]
    return result.filter(item => !!item).join(' · ')
}

const form = useForm({
    start: null ?? new Date(),
    end: null ?? new Date(new Date().setDate(new Date().getDate() + 2)),
    range: 2,
    guests: 2,
    children: 0,
    babies: 0,
})

const detalizationText = computed(() => {
    let nights = null
    if (form.range <= 1 || form.range === 21) {
        nights = `${form.range} ночь`
    }
    if (form.range > 1 && form.range <= 5 || form.range > 21 && form.range <= 24) {
        nights = `${form.range} ночи`
    }
    if (form.range > 5 && form.range <= 20 || form.range > 24) {
        nights = `${form.range} ночей`
    }
    return `${props.apartment.data.weekdays_price.toLocaleString()}₽ x ${nights}`
})

const handleSetDates = (dates) => {
    form.start = dates.start
    form.end = dates.end
    const start = dayjs(dates.start)
    const end = dayjs(dates.end)
    form.range = end.diff(start, 'day')
}

const details = ref([])

const basePrice = computed(() => {
    const start = dayjs(form.start)
    const end = dayjs(form.end)
    details.value = []
    let sum = 0
    for (let date = start; date.isBefore(end); date = date.add(1, 'day')) {
        const price = (date.day() === 5 || date.day() === 6)
            ? props.apartment.data.weekends_price
            : props.apartment.data.weekdays_price
        details.value.push({
            date: date.format('DD.MM.YYYY'),
            price
        })
        sum += price
    }
    return sum
})

const goToChat = () => {
    return router.visit(route('apartments.chat', {
        apartment: props.apartment.data.id
    }))
}
</script>

<template>
    <AppLayout>
        <Container>
            <div
                v-if="props.apartment.data.address"
                class="text-3xl font-semibold"
            >
                {{ props.apartment.data.address }}
            </div>
            <Gallery
                class="mt-6"
                :images="apartment.data.media"
            />
            <div class="flex  flex-col items-start md:flex-row gap-6 justify-between mt-6 relative">
                <div class="w-full">
                    <Heading
                        :title="getTitle()"
                        :subtitle="getSubtitle()"
                    />
                    <hr class="my-4"/>
                    <div class="flex justify-between gap-x-6">
                        <div class="flex min-w-0 gap-x-4">
                            <Avatar :src="props.apartment.data.owner.avatar" class="h-12 w-12 flex-none rounded-full bg-gray-50"/>
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">Хозяин: {{ props.apartment.data.owner.name }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ props.apartment.data.owner.email }}</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">Владелец</p>
                            <p class="mt-1 text-xs leading-5 text-gray-500">На сайте <time datetime="2023-01-23T13:23Z">2 года</time></p>
                        </div>
                    </div>
                    <template v-if="!!props.apartment.data.features.length">
                        <hr class="my-4"/>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div v-for="feature in props.apartment.data.features" :key="feature.id"
                                 class="flex items-center gap-3">
                                <div class="text-neutral-800" v-html="feature.icon"></div>
                                <div class="text-sm text-neutral-500">{{ feature.title }}</div>
                            </div>
                        </div>
                    </template>
                    <!--                    <hr class="my-4"/>-->
                    <!--                    <div class="text-xl">-->
                    <!--                        {{ props.apartment.data.category?.title }}-->
                    <!--                    </div>-->
                    <hr class="my-4"/>
                    <div class="mt-6">
                        {{ props.apartment.data.description ?? 'Тут описание квартиры' }}
                    </div>
                </div>
                <div class="md:sticky rounded-lg shadow-lg border border-neutral-100 md:w-7/12 lg:1/3 top-28 p-6">
                    <div class="text-2xl md:text-3xl font-semibold">
                        {{ props.apartment.data.weekdays_price?.toLocaleString() }}₽
                        <span class="text-neutral-500 font-light text-sm">ночь</span>
                    </div>
                    <div class="mt-4">
                        <Calendar range :start="form.start" :end="form.end" @setDates="handleSetDates"/>
                        <Counter
                            v-model="form.guests"
                            class="mt-4"
                            title="Гости"
                            subtitle="Укажите количество гостей"
                        />
                        <Counter
                            v-model="form.children"
                            class="mt-4"
                            title="Дети"
                            subtitle="2-12 лет"
                        />
                        <Counter
                            v-model="form.babies"
                            class="mt-4"
                            title="Младенцы"
                            subtitle="До 2-х лет"
                        />
                    </div>
                    <hr class="mt-4"/>
                    <dl class="divide-y divide-gray-100">
                        <div class="py-4 flex w-full items-baseline justify-between">
                            <dt class="font-light leading-6 text-пкфн-600">
                                <Popover class="relative">
                                    <PopoverButton
                                        class="font-light leading-none text-gray-600 outline-none border-b border-gray-400 hover:border-gray-600 transition">
                                        {{ detalizationText }}
                                    </PopoverButton>

                                    <transition
                                        enter-active-class="transition duration-200 ease-out"
                                        enter-from-class="translate-y-1 opacity-0"
                                        enter-to-class="translate-y-0 opacity-100"
                                        leave-active-class="transition duration-150 ease-in"
                                        leave-from-class="translate-y-0 opacity-100"
                                        leave-to-class="translate-y-1 opacity-0"
                                    >
                                        <PopoverPanel
                                            class="absolute left-1/2 z-10 mt-3 w-screen max-w-xs  z-10 bg-white  -translate-x-1/2 transform px-4 sm:px-0"
                                        >
                                            <div
                                                class="overflow-hidden h-full rounded-lg shadow-lg ring-1 ring-black/5">
                                                <dl class="divide-y divide-gray-100 max-h-52 overflow-auto">
                                                    <div
                                                        class="py-1 px-4 flex w-full items-baseline  justify-between"
                                                        v-for="item in details" :key="item.date">
                                                        <dt class="font-light text-sm leading-6 text-gray-600">{{
                                                                item.date
                                                            }}
                                                        </dt>
                                                        <dd class="mt-1 text-sm font-medium leading-6 text-neutral-600 ">{{
                                                                item.price?.toLocaleString()
                                                            }}₽
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>

                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                            </dt>
                            <dd class="mt-1 font-medium leading-6 text-neutral-600 ">{{
                                    basePrice?.toLocaleString()
                                }}₽
                            </dd>
                        </div>
                    </dl>
                    <hr class="mb-4"/>
                    <div class="flex flex-col gap-3">
                        <ButtonComponent v-if="props.apartment.data.fast_reserve" label="Моментальное бронирование"/>
                        <ButtonComponent :outline="true" @click="goToChat" label="Продолжить"/>
                    </div>
                    <div class="font-light text-sm text-center mt-3 text-neutral-500">Пока вы ни за что не платите</div>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>
