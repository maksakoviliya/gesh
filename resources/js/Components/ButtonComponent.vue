<script setup>
import {computed} from "vue";

const props = defineProps({
    label: String,
    onClick: Function,
    disabled: Boolean | null,
    outline: Boolean | null,
    small: Boolean | null,
})

const className = computed(() => {
    return `relative
    disabled:opacity-70
    disabled:cursor-not-allowed
    rounded-lg
    hover:opacity-80
    transition
    w-full
    ${props.outline ? 'bg-white' : 'bg-sky-600'}
    ${props.outline ? 'border-black' : 'border-sky-600'}
    ${props.outline ? 'text-black' : 'text-white'}
    ${props.small ? 'text-sm' : 'text-md'}
    ${props.small ? 'py-1' : 'py-3'}
    ${props.small ? 'font-light' : 'font-semibold'}
    ${props.small ? 'border-[1px]' : 'border-2'}`
})
</script>

<template>
    <button
        :disabled="disabled"
        @click="onClick"
        :class="className"
    >
        {{ label }}
    </button>
</template>
