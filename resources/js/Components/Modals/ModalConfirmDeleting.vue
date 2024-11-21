<script setup>
	import Modal from '@/Components/Modals/Modal.vue'
	import Heading from '@/Components/Heading.vue'

	defineProps({
		isOpen: Boolean,
		title: {
			type: String,
			default: 'Удалить объект',
		},
	})

	const emit = defineEmits(['onClose', 'onSubmit'])

	const handleClose = () => {
		emit('onClose')
	}

	const handleSubmit = () => {
		emit('onSubmit')
	}
</script>

<template>
	<Modal
		:is-open="isOpen"
		@onSecondaryAction="handleClose"
		@onClose="handleClose"
		@onSubmit="handleSubmit"
		:title="title"
		action-label="Удалить"
		secondary-action-label="Отменить"
		action-color="danger"
	>
		<template #body>
			<slot>
				<Heading
					title="Вы уверены что хотите удалить объект?"
					subtitle="Пока его еще можно будет восстановить, обратившись к администратору сайта."
				/>
			</slot>
		</template>
	</Modal>
</template>
