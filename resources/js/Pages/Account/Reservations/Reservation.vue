<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/Container.vue'
import Heading from "@/Components/Heading.vue";
import {computed, ref} from "vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import ButtonComponent from "@/Components/ButtonComponent.vue";
import {Link} from "@inertiajs/vue3";
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import dayjs from "dayjs";
import customParseFormat from "dayjs/plugin/customParseFormat.js";

const props = defineProps({
    reservation: {
        type: Object,
    }
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
    {
        id: 'reservation',
        route: route('account.reservations.view', {
            reservation: props.reservation.data?.id
        }),
        label: 'Бронирование',
    },
])

const details = ref([])

const basePrice = computed(() => {
    dayjs.extend(customParseFormat)
    const start = dayjs(props.reservation.data.start, 'DD.MM.YYYY')
    const end = dayjs(props.reservation.data.end, 'DD.MM.YYYY')
    details.value = []
    let sum = 0
    for (let date = start; date.isBefore(end); date = date.add(1, 'day')) {
        const price = (date.day() === 5 || date.day() === 6)
            ? props.reservation.data.apartment.weekends_price
            : props.reservation.data.apartment.weekdays_price
        const customPrice = props.reservation.data.apartment.dates.find(item => {
            const customDate = dayjs(item.date)
            return customDate.isSame(date)
        })?.price
        const totalPrice = customPrice ?? price
        details.value.push({
            date: date.format('DD.MM.YYYY'),
            price: totalPrice
        })
        sum += totalPrice
    }
    return sum
})

const detalizationText = computed(() => {
    let nights = null
    if (props.reservation.data.range <= 1 || props.reservation.data.range === 21) {
        nights = `${props.reservation.data.range} ночь`
    }
    if (props.reservation.data.range > 1 && props.reservation.data.range <= 5 || props.reservation.data.range > 21 && props.reservation.data.range <= 24) {
        nights = `${props.reservation.data.range} ночи`
    }
    if (props.reservation.data.range > 5 && props.reservation.data.range <= 20 || props.reservation.data.range > 24) {
        nights = `${props.reservation.data.range} ночей`
    }
    return `${nights}`
})

const subtitle = computed(() => {
    const result = [
        `${props.reservation.data.apartment.guests}&nbsp;гостей`,
        `${props.reservation.data.apartment.bedrooms}&nbsp;спальня`,
        `${props.reservation.data.apartment.beds}&nbsp;кровать`,
        `${props.reservation.data.apartment.bathrooms}&nbsp;ванная`,
    ]
    return result.filter(item => !!item).join(' · ')
})
</script>

<template>
    <AppLayout>
        <Container>
            <Breadcrumbs :routes="routes"/>

            <div class="relative flex-col md:flex-row flex items-start gap-4 mt-6">
                <div class="md:w-1/2 lg:w-2/3">
                    <Heading title="Бронирование подтверждено" subtitle="Вы успешно забронировали жилье"/>
                    <div>
                        <div class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100">
                            Ваша поездка:
                        </div>
                        <div class="mt-3">
                            <div class="text-sm font-medium">
                                Даты:
                            </div>
                            <div class="font-light">{{ props.reservation.data.start }} -
                                {{ props.reservation.data.end }}
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-sm font-medium">
                                Гости:
                            </div>
                            <div class="font-light">{{ props.reservation.data.guests }} гостя</div>
                            <div class="font-light" v-if="props.reservation.data.children">
                                {{ props.reservation.data.children }} детей
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100">
                            Управление бронированием:
                        </div>
                        <div class="mt-3 flex gap-4">
                            <ButtonComponent :disabled="true" :auto-width="true" class="px-12" label="Отменить" />
                            <ButtonComponent :disabled="true" :auto-width="true" :outline="true" class="px-12" label="Возникли трудности" />
                        </div>
                    </div>
                </div>
                <div
                    class="md:sticky w-full md:w-1/2 lg:w-1/3   rounded-lg shadow-lg border border-neutral-100 top-28 p-6">
                    <div class="flex items-stretch justify-start gap-4">
                        <Link
                            :href="
								route('apartment', {
									apartment: props.reservation.data.apartment?.id,
								})
							"
                            class="h-24 w-32 rounded-lg overflow-hidden"
                        >
                            <img
                                :src="props.reservation.data.apartment?.media[0]?.src"
                                class="h-full w-full object-cover"
                                alt=""
                            />
                        </Link>
                        <div class="flex flex-col justify-between">
                            <div class="text-gray-600 font-light">
                                {{ props.reservation.data?.apartment?.category?.title }}
                            </div>
                            <div class="font-light text-xs text-gray-600 mt-1" v-html="subtitle">
                            </div>
                        </div>
                    </div>
                    <div class="font-semibold text-xl mt-4 pt-2 border-t border-gray-100">
                        Детализация цены:
                    </div>
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
                                                        <dd class="mt-1 text-sm font-medium leading-6 text-neutral-600 ">
                                                            {{
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
                        <div class="py-2 flex w-full items-baseline justify-between">
                            <dt class="font-light leading-6 text-пкфн-600">
                                <div>Гости:</div>
                            </dt>
                            <dd class="mt-1 font-medium leading-6 text-neutral-600 ">
                                {{ props.reservation.data.guests }}
                            </dd>
                        </div>
                        <div class="py-2 flex w-full items-baseline justify-between"
                             v-if="props.reservation.data.children > 0">
                            <dt class="font-light leading-6 text-пкфн-600">
                                <div>Дети:</div>
                            </dt>
                            <dd class="mt-1 font-medium leading-6 text-neutral-600 ">
                                {{ props.reservation.data.children }}
                            </dd>
                        </div>
                        <div class="py-2 flex w-full items-baseline justify-between">
                            <dt class="font-light leading-6 text-пкфн-600">
                                <div>Стоимость:</div>
                            </dt>
                            <dd class="mt-1 font-medium leading-6 text-neutral-600 ">
                                {{ props.reservation.data.price.toLocaleString() }}₽
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>
