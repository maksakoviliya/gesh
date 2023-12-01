<script setup>
import Avatar from "@/Components/Avatar.vue";

const props = defineProps({
    item: {
        required: true
    },
    compact: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
<div class="border border-gray-300 rounded-lg p-3">
    <div class="flex items-baseline justify-between " :class="props.compact ? 'flex-col-reverse gap-0' : 'gap-4'">
        <div class="font-semibold text-neutral-800">Запрос на бронирование</div>
        <div class="font-light text-xs text-gray-400">{{props.item.created_at}}</div>
    </div>
    <div class="font-light text-neutral-800">с {{ props.item.start }} по {{ props.item.end}} | <span class="text-neutral-400 text-sm">{{props.item.range}} ночи</span></div>
    <div class="font-light text-neutral-800">Взрослые {{ props.item.range }} <span v-if="props.item.children > 0" > | Дети {{props.item.children}}</span></div>
</div>
</template>
