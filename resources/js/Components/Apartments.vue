<script setup>
import AppartmentsCard from "@/Components/AppartmentsCard.vue";
import EmptyState from "@/Components/EmptyState.vue";

defineProps({
    apartments: Array | null
})
</script>

<template>
    <EmptyState title="Ничего не найдено" subtitle="Не удалось найти жилья по вашему запросу"
                v-if="!apartments.data.length"/>
    <div v-else class="pt-4
            grid
            grid-cols-1
            sm:grid-cols-2
            md:grid-cols-3
            lg:grid-cols-4
            xl:grid-cols-5
            2xl:grid-cols-6
            gap-8">
        <AppartmentsCard
            v-for="apartment in apartments.data"
            :key="apartment.id"
            :apartment="apartment"/>
    </div>
</template>
