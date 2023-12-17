<script setup>
import {computed} from "vue";

const props = defineProps({
    active: [Boolean],
    default: false
})

const activeClass = computed(() => {
    if (props.active) {
        return 'text-blue-600 border-blue-600  active dark:text-blue-500 dark:border-blue-500'
    }
    return 'border-transparent  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'
})
</script>

<template>
    <li class="me-2">
        <button class="inline-block p-4 border-b-2  rounded-t-lg
" :class="activeClass">
            <slot/>
        </button>
    </li>
</template>

