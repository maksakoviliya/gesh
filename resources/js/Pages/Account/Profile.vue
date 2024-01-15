<script setup>
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'
	import { ref } from 'vue'
	import Heading from '@/Components/Heading.vue'
	import AvatarUploader from '@/Components/AvatarUploader.vue'
	import ProfileForm from '@/Components/ProfileForm.vue'

	defineProps({
		user: Object,
	})

	const routes = ref([
		{
			id: 'account',
			route: route('account.index'),
			label: 'Аккаунт',
		},
		{
			id: 'profile',
			route: route('account.profile.index'),
			label: 'Профиль',
		},
	])
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<Breadcrumbs :routes="routes" />
			<Heading
				class="mt-6"
				title="Профиль"
				subtitle="Отредактируйте ваши персональные данные"
			/>
			<div class="flex flex-col md:flex-row mt-12 gap-12 items-start">
				<div
					class="rounded-xl border border-neutral-100 dark:border-slate-700 shadow-xl p-8 w-full md:w-1/2 lg:w-1/3"
				>
					<AvatarUploader :src="user.data.avatar" />
					<div class="text-center font-semibold text-3xl mt-3 dark:text-slate-100">{{ user.data.name }}</div>
					<div class="text-center mt-1 text-sm dark:text-slate-500">На сайте {{ user.data.since }}</div>
				</div>
				<div class="w-full md:w-1/2 lg:w-2/3">
					<ProfileForm :user="user.data" />
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
