<script setup>
	import { Head, Link, useForm } from '@inertiajs/vue3'
	import ModalLayout from '@/Layouts/ModalLayout.vue'
	import Heading from '@/Components/Heading.vue'
	import Input from '@/Components/Input.vue'
	import { ref } from 'vue'
	import PhoneInput from '@/Components/PhoneInput.vue'

	import SocialAuth from '@/Pages/Auth/SocialAuth.vue'

	const form = useForm({
		name: '',
		phone: '',
		email: '',
		password: '',
	})

	const submit = () => {
		form.post(route('register'), {
			onFinish: () => form.reset('password'),
		})
	}

	const type = ref('phone')
</script>

<template>
	<Head title="Register" />

	<ModalLayout
		actionLabel="Зарегистрироваться"
		:handleSubmit="submit"
	>
		<template #title> Регистрация </template>
		<template #body>
			<div class="flex flex-col gap-4">
				<Heading
					title="Добро пожаловать"
					subtitle="Создать аккаунт"
				/>
				<Input
					id="email"
					v-model="form.email"
					label="Email"
					:error="form.errors.email"
					required
				/>
				<PhoneInput
					id="phone"
					v-model="form.phone"
					label="Телефон"
					:error="form.errors.phone"
					required
				/>
				<Input
					id="name"
					v-model="form.name"
					label="Имя"
					:error="form.errors.name"
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
				Уже есть аккаунт?
				<Link
					:href="route('login')"
					class="underline hover:text-neutral-700 dark:hover:text-slate-300"
					>Войти</Link
				>
			</div>
		</template>
	</ModalLayout>
</template>
