<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiSolidMenu, HiX } from 'oh-vue-icons/icons'
	import { computed, onMounted, ref } from 'vue'
	import Avatar from '@/Components/Avatar.vue'
	import MenuLink from '@/Components/MenuLink.vue'
	import { router, usePage } from '@inertiajs/vue3'
	import ModalLogout from '@/Components/Modals/ModalLogout.vue'
	import useToasts from '@/hooks/useToasts'
	import Popover from '@/Components/Interactive/Popover.vue'
	import Indicator from '@/Components/Interactive/Indicator.vue'
	import { initFlowbite } from 'flowbite'
	import DarkModeToggle from '@/Components/DarkModeToggle.vue'

	addIcons(HiSolidMenu, HiX)

	const isOpen = ref(false)
	const setIsOpen = (value) => {
		isOpen.value = value
	}
	const toggleOpen = () => {
		setIsOpen(!isOpen.value)
	}

	const { successToast } = useToasts()

	const logout = () => {
		router.post(route('logout'))
		setShowLogoutDialog(false)
		successToast('Вы успешно вышли из аккаунта.')
	}

	const page = usePage()
	const avatar = computed(() => {
		return page.props.user?.data?.avatar ?? null
	})

	const showLogoutDialog = ref(false)
	const setShowLogoutDialog = (value) => {
		showLogoutDialog.value = value
	}

	const redirectToDashboard = () => {
		window.location.href = route('filament.admin.pages.dashboard')
	}

	const unreadNotificationsCount = ref(0)

	onMounted(() => {
		if (!page.props.user) {
			return
		}
		axios.get(route('has_unread_notifications')).then((res) => {
			unreadNotificationsCount.value = res.data?.unread_notifications_count ?? 0
		})
	})
</script>

<template>
	<div class="relative">
		<ModalLogout
			:is-open="showLogoutDialog"
			@onClose="setShowLogoutDialog(false)"
			@onLogout="logout"
		/>

		<Popover
			max-width-class="max-w-[40vw] md:max-w-[22vw]"
			position="left"
		>
			<template #toggle>
				<div
					class="p-4 md:py-1 md:px-2 border dark:border-slate-700 dark:text-slate-200 border-neutral-200 flex flex-row items-center gap-3 rounded-full cursor-pointer hover:shadow-md transition"
				>
					<OhVueIcon
						name="hi-solid-menu"
						v-if="!isOpen"
					/>
					<OhVueIcon
						name="hi-x"
						v-else
					/>
					<div class="hidden md:block text-neutral-800 dark:text-slate-200">
						<Avatar :src="avatar" />
					</div>

					<Indicator
						:count="unreadNotificationsCount"
						hidden-count
					/>
				</div>
			</template>
			<template #content>
				<div
					class="rounded-xl shadow-md dark:shadow-xl dark:border overflow-hidden dark:border-slate-700 w-[40vw] md:w-[22vw] bg-white dark:bg-slate-800 text-sm"
				>
					<div class="flex flex-col cursor-pointer">
						<div class="p-4">
							<DarkModeToggle />
						</div>
						<hr class="dark:border-slate-600" />
						<template v-if="!$page.props.user">
							<MenuLink
								:href="route('login')"
								label="Войти"
							/>
							<MenuLink
								:href="route('register')"
								label="Зарегистрироваться"
							/>
						</template>
						<template v-else>
							<MenuLink
								:href="route('account.index')"
								label="Аккаунт"
							/>
							<MenuLink
								:href="route('account.index')"
								label="Сообщения"
							/>
							<MenuLink :href="route('account.notifications.index')">
								<div class="inline-block relative pr-4">
									Уведомления
									<Indicator :count="unreadNotificationsCount" />
								</div>
							</MenuLink>
							<hr class="dark:border-slate-600" />
							<MenuLink
								v-if="$page.props.user.data.is_admin"
								@click="redirectToDashboard"
								label="Дашборд"
							/>
							<MenuLink
								@click="setShowLogoutDialog(true)"
								label="Выйти"
							/>
						</template>
					</div>
				</div>
			</template>
		</Popover>
	</div>
</template>
