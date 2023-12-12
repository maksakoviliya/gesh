<script setup>
import {Link} from "@inertiajs/vue3";
defineProps({
    href: String,
    label: String
})
defineEmits([
    'click'
])
const linkClass = 'px-4 py-3 hover:bg-neutral-100 dark:hover:bg-slate-700 dark:text-slate-100 transition font-semibold'
</script>

<template>
    <Link :href="href" v-if="href" :class="linkClass">
        {{ label }}
    </Link>
    <div @click="$emit('click')" v-else :class="linkClass">
        {{ label }}
    </div>
</template>

