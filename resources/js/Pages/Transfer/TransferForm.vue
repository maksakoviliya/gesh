<script setup>
	import { router, useForm, usePage } from '@inertiajs/vue3'
	import PhoneInput from '@/Components/PhoneInput.vue'
	import Container from '@/Components/Container.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import Input from '@/Components/Input.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import useToasts from '@/hooks/useToasts'
	import { ref } from 'vue'

	const page = usePage()
	const form = useForm({
		name: page.props.user?.data?.name,
		phone: page.props.user?.data?.phone,
	})
	const { successToast } = useToasts()

	const done = ref(false)

	const submit = () => {
		form.post(route('transfer.schedule'), {
			onSuccess: () => {
				form.reset()
				done.value = true
				successToast('Заявка на трансфер отправлена')
			},
			preserveScroll: true,
		})
	}
</script>

<template>
	<Container
		class="mt-6"
		:xs="true"
	>
		<EmptyState
			v-if="done"
			title="Запрос отправлен"
			subtitle="Ожидайте, скоро наш специалист свяжется с вами и уточнит все детали по трансферу и ответит на все ваши вопросы"
			action-label="Забронировать жилье"
			@click="router.visit('/')"
		/>
		<div
			class="flex flex-col gap-3 mt-10 justify-center"
			v-else
		>
			<div class="text-2xl md:text-4xl font-semibold text-neutral-800 dark:text-white">Узнать подробнее</div>
			<Input
				class="mt-10"
				v-model="form.name"
				name="name"
				:error="form.errors.name"
				label="Как вас зовут"
				id="name"
			/>
			<PhoneInput
				v-model="form.phone"
				name="phone"
				:error="form.errors.phone"
				label="Телефон"
				id="phone"
			/>
			<ButtonComponent
				label="Отправить"
				:auto-width="true"
				class="max-w-xs mt-4 text-xl"
				@click="submit"
			/>
		</div>
	</Container>
</template>
