<script setup>
import {OhVueIcon, addIcons} from "oh-vue-icons";
import {BiSearch} from "oh-vue-icons/icons";
import {computed} from "vue";


addIcons(BiSearch);

const locationLabel = computed(() => {
    return 'Везде'
})
const durationLabel = computed(() => {
    return 'Неделя'
})
const guestLabel = computed(() => {
    return 'Гости'
})
</script>

<template>
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
                >
                    <OhVueIcon name="bi-search" />
                </div>
            </div>
        </div>
    </div>
</template>
