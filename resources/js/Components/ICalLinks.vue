<script setup>
import Input from "@/Components/Input.vue";
import ButtonComponent from "@/Components/ButtonComponent.vue";
import { OhVueIcon, addIcons } from 'oh-vue-icons'
import { HiSolidPlusSm, HiSolidTrash } from 'oh-vue-icons/icons'
import {onMounted, ref} from "vue";
import {initFlowbite} from "flowbite";

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    errors: {
        type: [Object, Array]
    }
})

onMounted(() => {
    initFlowbite()
})

addIcons(HiSolidPlusSm, HiSolidTrash)

const emit = defineEmits([
    'update:modelValue',
    'reset'
])

const newLink = ref('')

const handleAdd = () => {
    let links = [...props.modelValue]
    links.push({
        id: `${newLink.value}_${Date.now()}`,
        link: newLink.value
    })
    emit('update:modelValue', links)
    newLink.value = ''
}
const handleDelete = (i) => {
    let links = [...props.modelValue]
    links.splice(i, 1)
    emit('update:modelValue', links)
    emit('reset')
}
</script>

<template>
    <div class="flex flex-col gap-3 z-20">
        <div v-for="(link, i) in props.modelValue" :key="link.id">
            <div class="flex items-center justify-between gap-4 relative">
                <div class="text-ellipsis overflow-hidden font-light"
                     :class="props.errors[`i_cal_links.${i}.link`] ? 'text-rose-500' : 'text-neutral-800 dark:text-slate-200 '"
                     :data-tooltip-target="`tooltip-for-link-${i}`"
                >
                    {{ link.link }}
                </div>
                <div :id="`tooltip-for-link-${i}`"
                     role="tooltip"
                     class="absolute z-10  max-w-full break-words invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                >
                    {{  link.link }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <div
                    @click="handleDelete(i)"
                    class="rounded-full cursor-pointer text-neutral-800 dark:text-slate-400 hover:opacity-80 bg-sky-700 dark:bg-sky-800 w-6 h-6 aspect-square flex items-center justify-center flex-col">
                    <OhVueIcon name="hi-solid-trash"  scale="0.8"/>
                </div>
            </div>
        </div>
        <div class="flex gap-1 items-center" v-if="props.modelValue.length <= 4">
            <Input id="link" v-model="newLink" label="Ссылка на .ical файл" />
            <ButtonComponent :disabled="!newLink" @click="handleAdd" :small="true" :auto-width="true" class="w-8 h-8 aspect-square" :circle="true">
                <template #icon>
                    <OhVueIcon name="hi-solid-plus-sm" />
                </template>
            </ButtonComponent>
        </div>
    </div>
</template>

