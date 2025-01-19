<script setup>
	import { Link } from '@inertiajs/vue3'

	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import { computed, ref } from 'vue'
	import Heading from '@/Components/Heading.vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { RiProfileLine, MdMapshomeworkOutlined } from 'oh-vue-icons/icons'
	addIcons(RiProfileLine, MdMapshomeworkOutlined)

	const sections = ref([
		{
			id: 'profile',
			key: 'profile.index',
			title: 'Личная информация',
			subtitle: 'Предоставьте личные и контактные данные',
			icon: 'ri-profile-line',
		},
		{
			id: 'apartments',
			key: 'apartments.list',
			title: 'Мои объекты',
			subtitle: 'Ваша недвижимость для аренды',
			icon: 'md-mapshomework-outlined',
		},
	])

	const props = defineProps({
		user: Object,
	})

	const subtitle = computed(() => {
		return [props.user.data.name, props.user.data.email, props.user.data.phone].filter((item) => !!item).join(', ')
	})
</script>

<template>
	<AppLayout>
		<Container :sm="true">
			<div class="flex mt-12 w-full flex-col md:flex-row justify-between">
				<Heading
					title="Аккаунт"
					:subtitle="subtitle"
				/>
				<div class="text-right">
					<div class="dark:text-slate-300">У нас есть телеграм бот!</div>
					<a
						href="https://t.me/gesh_resort_bot"
						target="_blank"
						class="dark:text-white hover:underline cursor-pointer text-sm font-bold"
						>@gesh_resort_bot</a
					>
				</div>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-10 gap-6">
				<Link
					:href="route(`account.${section.key}`)"
					class="shadow-lg p-6 rounded-xl hover:shadow-xl transition cursor-pointer border border-neutral-100 dark:border-slate-700 hover:opacity-70"
					v-for="section in sections"
					:key="section.id"
				>
					<OhVueIcon
						:name="section.icon"
						class="text-neutral-400 dark:text-slate-200"
						scale="2"
					/>
					<div class="text-lg font-semibold mt-6 dark:text-white">
						<div class="relative inline-block w-auto">
							{{ section.title }}
						</div>
					</div>
					<div class="text-neutral-500 font-light dark:text-slate-400">{{ section.subtitle }}</div>
				</Link>
			</div>
		</Container>
	</AppLayout>
</template>
