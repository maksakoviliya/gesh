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
			key: 'profile',
			title: 'Личная информация',
			subtitle: 'Предоставьте личные и контактные данные',
			icon: 'ri-profile-line',
		},
		{
			id: 'reservations',
			key: 'profile',
			title: 'Мои бронирования',
			subtitle: 'Места куда вы поедете',
			icon: 'md-mapshomework-outlined',
		},
		{
			id: 'apartments',
			key: 'apartments',
			title: 'Мои объекты',
			subtitle: 'Ваша недвижимость для проживания',
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
			<Heading
				class="mt-12"
				title="Аккаунт"
				:subtitle="subtitle"
			/>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-10 gap-6">
				<Link
					:href="route(`account.${section.key}`)"
					class="shadow-lg p-6 rounded-xl hover:shadow-xl transition cursor-pointer border border-neutral-100 hover:opacity-70"
					v-for="section in sections"
					:key="section.id"
				>
					<OhVueIcon
						:name="section.icon"
						class="text-neutral-400"
						scale="2"
					/>
					<div class="text-lg font-semibold mt-6">
						{{ section.title }}
					</div>
					<div class="text-neutral-500 font-light">{{ section.subtitle }}</div>
				</Link>
			</div>
		</Container>
	</AppLayout>
</template>
