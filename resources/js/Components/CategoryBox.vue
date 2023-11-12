<script setup>
import {computed} from "vue";
import qs from 'query-string'
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    category: Array | Object,
    selected: Boolean
})

const classComputed = computed(() => `flex
        flex-col
        items-center
        justify-center
        gap-2
        p-3
        border-b-2
        hover:text-neutral-800
        transition
        cursor-pointer
        ${props.selected ? 'border-b-neutral-800' : 'border-transparent'}
    ${props.selected ? 'text-neutral-800' : 'text-neutral-500'}`)

const page = usePage()
const handleClick = () => {
    let currentQuery = {};
    const params = page.props.query
    params['category'] = params['category'] === props.category.slug
        ? null
        : props.category.slug

    const url = qs.stringifyUrl({
        url: '/',
        query: params
    }, {skipNull: true});

    router.visit(url)
    //
    // const updatedQuery: any = {
    //     ...currentQuery,
    //     category: label
    // }
    //
    // if (params?.get('category') === label) {
    //     delete updatedQuery.category;
    // }
    //

    //
    // router.push(url);
}
</script>

<template>
    <div
        @click="handleClick"
        :class="classComputed"
    >
        <div v-html="category.icon"></div>
        <div class="font-medium text-sm">
            {{ category.title }}
        </div>
    </div>
</template>
