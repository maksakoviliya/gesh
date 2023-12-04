<script setup>
import {computed} from "vue";

const props = defineProps({
    label: {
        type: [String, Number],
        required: true
    },
    type: {
        type: String
    }
})

const classes  = computed(() => {
    switch (props.type) {
        case 'success':
            return 'bg-green-200 text-teal-800'
        case 'warning':
            return 'bg-yellow-200 text-yellow-800'
        default:
            return 'bg-gray-200 text-neutral-800'
    }
})
</script>

<template>
<div :class="classes" class="px-2 rounded-full text-xs font-semibold leading-none flex items-center justify-center py-1">{{ props.label}}</div>
</template>
