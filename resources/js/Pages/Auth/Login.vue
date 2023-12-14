<script setup>
	import { Head, useForm, Link } from '@inertiajs/vue3'
	import ModalLayout from '@/Layouts/ModalLayout.vue'
	import Heading from '@/Components/Heading.vue'
	import Input from '@/Components/Input.vue'
	import { ref } from 'vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import PhoneInput from '@/Components/PhoneInput.vue'
	import useToasts from '@/hooks/useToasts'
	import SocialAuth from '@/Pages/Auth/SocialAuth.vue'

	defineProps({
		canResetPassword: Boolean,
		status: String,
	})

	const form = useForm({
		email: '',
		phone: '',
		password: '',
	})

	const { successToast, errorToast } = useToasts()

	const submit = () => {
		form.transform((data) => {
			if (type.value === 'email') {
				delete data.phone
			} else {
				delete data.email
			}
			return data
		}).post(route('login'), {
			onError: (error) => {
				form.setError('email', error.email)
				errorToast('Возникла ошибка.')
			},
			onSuccess: (res) => {
				console.log('res', res)
				successToast('Успешный вход в аккаунт.')
				form.reset('password')
			},
		})
	}

	const type = ref('phone')
</script>

<template>
	<Head title="Log in" />

	<ModalLayout
		actionLabel="Войти"
		:handleSubmit="submit"
	>
		<template #title> Вход </template>
		<template #body>
			<div class="flex flex-col gap-4">
				<Heading
					title="С возвращением"
					subtitle="Войти в свой аккаунт"
				/>
				<div class="flex items-center gap-4">
					<ButtonComponent
						:small="true"
						@click="type = 'phone'"
						:outline="type !== 'phone'"
						label="Телефон"
					/>
					<ButtonComponent
						:small="true"
						@click="type = 'email'"
						:outline="type !== 'email'"
						label="Почта"
					/>
				</div>
				<Input
					id="email"
					v-model="form.email"
					v-if="type === 'email'"
					label="Email"
					:error="form.errors.email"
					required
				/>
				<PhoneInput
					id="phone"
					v-if="type === 'phone'"
					v-model="form.phone"
					label="Телефон"
					:error="form.errors.phone ?? form.errors.email"
					required
				/>
				<Input
					id="password"
					v-model="form.password"
					label="Пароль"
					:error="form.errors.password"
					type="password"
					required
				/>
			</div>
		</template>
		<template #footer>
			<hr class="my-4" />
			<div class="flex flex-col gap-2">
				<SocialAuth />
			</div>
			<div class="text-neutral-800 dark:text-slate-400 mt-4 text-sm text-center">
				Еще нет аккаунта?
				<Link
					:href="route('register')"
					class="underline hover:text-neutral-700 dark:hover:text-slate-300"
					>Зарегистрироваться</Link
				>
			</div>
		</template>
	</ModalLayout>
</template>
