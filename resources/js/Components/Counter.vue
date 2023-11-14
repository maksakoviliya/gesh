<script setup>
import {OhVueIcon, addIcons} from "oh-vue-icons";
import {HiSolidMinusSm, HiSolidPlusSm} from "oh-vue-icons/icons";
import {ref} from "vue";


addIcons(HiSolidMinusSm, HiSolidPlusSm);

defineProps({
    title: String,
    subtitle: String
})

const onReduce = () => {
    console.log('-')
}
const onAdd = () => {
    console.log('+')
}

const value = ref(1)
</script>

<template>
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-col">
            <div class="font-medium">{{ title }}</div>
            <div class="font-light text-gray-600">
                {{ subtitle }}
            </div>
        </div>
        <div class="flex flex-row items-center gap-4">
            <div
                @cick="onReduce"
                class="
            w-10
            h-10
            rounded-full
            border-[1px]
            border-neutral-400
            flex
            items-center
            justify-center
            text-neutral-600
            cursor-pointer
            hover:opacity-80
            transition
          "
            >
                <OhVueIcon name="hi-solid-minus-sm" />
            </div>
            <div
                class="
            font-light
            text-xl
            text-neutral-600
          "
            >
                {{ value }}
            </div>
            <div
                @click="onAdd"
                class="
            w-10
            h-10
            rounded-full
            border-[1px]
            border-neutral-400
            flex
            items-center
            justify-center
            text-neutral-600
            cursor-pointer
            hover:opacity-80
            transition
          "
            >
                <OhVueIcon name="hi-solid-plus-sm" />
            </div>
        </div>
    </div>
</template>

