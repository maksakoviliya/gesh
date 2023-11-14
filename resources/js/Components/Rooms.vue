<script setup>
import {OhVueIcon, addIcons} from "oh-vue-icons";
import { MdBed} from "oh-vue-icons/icons";

addIcons(MdBed)

defineProps({
    rooms: Number | String
})
</script>

<template>
<div class="flex items-center gap-1 font-semibold text-sm">
    <OhVueIcon name="md-bed" class="text-neutral-500" />
    {{ rooms }}
</div>
</template>

