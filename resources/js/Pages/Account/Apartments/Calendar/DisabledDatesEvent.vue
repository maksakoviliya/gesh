<script setup>
import ButtonComponent from "@/Components/ButtonComponent.vue";
import useToasts from "@/hooks/useToasts";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    event: Object,
})

const {successToast, errorToast} = useToasts()
const cancelBlock = () => {
    axios.delete(route('account.disabled-dates.delete', props.event.data.disabled_date.id))
        .then(() => {
            successToast('Блокировка успешно снята')
            router.visit(window.location.href, { only: [] });
        }).catch(err => {
        errorToast(err.message)
    })
}
</script>

<template>
    <div>
        <div class="text-neutral-800 dark:text-slate-200">
            C {{ props.event.data.disabled_date.start }} по {{ props.event.data.disabled_date.end }} жилье недоступно
            для бронирования
        </div>
        <ButtonComponent
            class="mt-6"
            label="Отменить блокировку"
            @click="cancelBlock"
        />
    </div>
</template>
