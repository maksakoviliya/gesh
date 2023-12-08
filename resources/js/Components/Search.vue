<script setup>
import {OhVueIcon, addIcons} from "oh-vue-icons";
import {BiSearch} from "oh-vue-icons/icons";
import {computed, ref} from "vue";
import Popover from "@/Components/Interactive/Popover.vue";
import Counter from "@/Components/Counter.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css'
import Input from "@/Components/Input.vue";
import dayjs from "dayjs";
import 'dayjs/locale/ru'

addIcons(BiSearch);

const locationLabel = computed(() => {
    return 'Везде'
})
const durationLabel = ref('Неделя')
const guestLabel = computed(() => {
    return 'Гости'
})

const guests = ref(2)
const children = ref(0)
const date = ref([
    new Date(),
    new Date(),
])

const handleSetDates = (dates) => {
    dayjs.locale('ru')
    let start = dayjs(dates[0])
    let end = dayjs(dates[1])
    console.log('start', start)
    console.log('end', end)
    if (start.date() === end.date()) {
        durationLabel.value = `${start.format('DD MMM')}`
        return
    }
    if (start.month() === end.month()) {
        durationLabel.value = `${start.date()} - ${end.date()} ${end.format('MMM')}`
        return;
    }
    durationLabel.value = `${start.format('DD MMM')} - ${end.format('DD MMM')}`
}

const  onSubmit = () => {
    console.log('Submit')
}
</script>

<template>
    <Popover max-width-class="max-w-3xl">
        <template #toggle>
            <div
                class="
        border-[1px]
        w-full
        md:w-auto
        py-2
        rounded-full
        shadow-sm
        hover:shadow-md
        transition
        cursor-pointer
      "
            >
                <div
                    class="
          flex
          flex-row
          items-center
          justify-between
        "
                >
                    <div
                        class="
            text-sm
            font-semibold
            px-6
          "
                    >
                        {{ locationLabel }}
                    </div>
                    <div
                        class="
            hidden
            sm:block
            text-sm
            font-semibold
            px-6
            border-x-[1px]
            flex-1
            text-center
          "
                    >
                        {{ durationLabel }}
                    </div>
                    <div
                        class="
            text-sm
            pl-6
            pr-2
            text-gray-600
            flex
            flex-row
            items-center
            gap-3
          "
                    >
                        <div class="hidden sm:block">{{ guestLabel }}</div>
                        <div
                            class="
              p-2
              bg-sky-600
              rounded-full
              text-white
            "
                            @click.prevent="onSubmit"
                        >
                            <OhVueIcon name="bi-search"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="p-4 h-auto flex items-stretch flex-col md:flex-row gap-2 md:gap-4 w-full justify-between">
                <div class="h-full overflow-auto w-full">
                    <Input  label="Город" />
                </div>
                <div class="h-full w-full">
                    <VueDatePicker :model-value="date"
                                   @update:model-value="handleSetDates"
                                   no-disabled-range
                                   range
                                   :partial-range="false"
                                   :inline="{ input: false }"
                                   text-input
                                   auto-apply
                                   :month-change-on-scroll="false"
                                   min-range="1"
                                   max-range="30"
                                   disable-year-select
                                   month-name-format="long"
                                   locale="ru"
                                   format="dd.MM.yyyy"
                                   placeholder="Выберите даты"
                                   :min-date="new Date()"
                                   :enable-time-picker="false"
                                   :hide-navigation="['month', 'year', 'time']" />
                </div>
                <div class="h-full overflow-auto w-full ">
                    <Counter
                        v-model="guests"
                        class="mt-4"
                        title="Гости"
                        subtitle="Укажите количество гостей"
                    />
                    <Counter
                        v-model="children"
                        class="mt-4"
                        title="Дети"
                        subtitle="0-12 лет"
                    />
                </div>
            </div>
        </template>
    </Popover>
</template>
