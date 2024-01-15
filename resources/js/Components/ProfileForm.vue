<script setup>
	import Input from '@/Components/Input.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import PhoneInput from '@/Components/PhoneInput.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import useToasts from '@/hooks/useToasts'

	const props = defineProps({
		user: {
			type: Object,
		},
	})

	const form = useForm({
		name: props.user.name,
		email: props.user.email,
		phone: props.user.phone,
		old_password: null,
		password: null,
		password_confirmation: null,
	})

	const { successToast } = useToasts()
	const submit = () => {
		form.post(
			route('account.profile.update', {
				account: props.user.id,
			}),
			{
				onSuccess() {
					successToast('Данные профиля успешно обновлены')
					form.reset()
				},
				preserveScroll: true,
			}
		)
	}
</script>
<template>
	<div class="flex flex-col gap-3">
		<Input
			key="name"
			label="Ваше имя"
			:error="form.errors.name"
			v-model="form.name"
		/>
		<Input
			key="email"
			label="Ваш email"
			:error="form.errors.email"
			v-model="form.email"
		/>
		<PhoneInput
			key="phone"
			label="Ваш телефон"
			:required="true"
			:error="form.errors.phone"
			v-model="form.phone"
		/>
		<hr class="my-4 dark:border-slate-600" />
		<Input
			key="old_password"
			label="Старый пароль"
			type="password"
			:error="form.errors.old_password"
			v-model="form.old_password"
		/>
		<Input
			key="password"
			label="Новый пароль"
			type="password"
			:error="form.errors.password"
			v-model="form.password"
		/>
		<Input
			key="password_confirmation"
			label="Повторите пароль"
			type="password"
			:error="form.errors.password_confirmation"
			v-model="form.password_confirmation"
		/>
		<div class="flex flex-col md:flex-row gap-4">
			<ButtonComponent
				class="mt-6"
				outline
				label="Отменить"
				@click="router.visit(route('account.index'))"
			/>
			<ButtonComponent
				class="mt-6"
				label="Сохранить"
				@click="submit"
			/>
		</div>
	</div>
</template>
