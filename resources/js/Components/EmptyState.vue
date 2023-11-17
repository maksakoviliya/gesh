<script setup>
import Heading from "@/Components/Heading.vue";
import ButtonComponent from "@/Components/ButtonComponent.vue";
import {router} from "@inertiajs/vue3";

defineProps({
    title: String,
    subtitle: String,
    actionLabel: String
})

const emit =defineEmits([
    'onClick'
])
</script>

<template>
    <div
        class="
        h-[60vh]
        flex
        flex-col
        gap-2
        justify-center
        items-center
      "
    >
        <Heading
            center
            :title="title"
            :subtitle="subtitle"
        />
        <div class="w-48 mt-4" v-if="actionLabel">
            <ButtonComponent
                :outline="true"
                :label="actionLabel"
                @click="emit('onClick')"
            />
        </div>
    </div>
</template>
