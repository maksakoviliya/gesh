<script setup>
import Avatar from "@/Components/Avatar.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
})
</script>

<template>
<div class="flex items-start gap-2">
    <Avatar :src="props.item.user?.avatar" />
    <div class="flex flex-col">
        <div class="text-sm font-bold"><span v-if="$page.props.user?.data?.id === props.item.user?.id" class="text-neutral-600">Вы:</span> {{props.item.user?.name }} <span class="font-light text-xs text-gray-400">{{props.item.created_at }}</span></div>
        <div class="">{{props.item.message }}</div>
    </div>
</div>
</template>

