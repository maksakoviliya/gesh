<script setup>
import Modal from "@/Components/Modals/Modal.vue";
import Heading from "@/Components/Heading.vue";

defineProps({
    isOpen: Boolean
})

const emit = defineEmits([
    'onClose',
    'onLogout'
])

const handleClose = () => {
    emit('onClose')
}

const handleSubmit = () => {
    emit('onLogout')
}
</script>

<template>
    <Modal :is-open="isOpen" @onSecondaryAction="handleClose" @onClose="handleClose" @onSubmit="handleSubmit"
           title="Выход из аккаунта" action-label="Выйти" secondary-action-label="Отменить">
        <template #body>
            <Heading title="Вы уверены что хотите выйти?"/>
        </template>
    </Modal>
</template>
