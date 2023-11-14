<script setup>
import { ref, onMounted } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const date = ref();

// For demo purposes assign range from the current date
onMounted(() => {
    const startDate = new Date();
    const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
    date.value = [startDate, endDate];
})

const format = ref('dd.MM.yyyy')
</script>

<template>
    <VueDatePicker v-model="date"
                   :partial-range="false"
                   auto-apply
                   disable-year-select
                   month-name-format="long"
                   locale="ru"
                   :format="format"
                   placeholder="Выберите даты"
                   :min-date="new Date()"
                   :enable-time-picker="false"
                   :hide-navigation="['month', 'year', 'time']" />
</template>
