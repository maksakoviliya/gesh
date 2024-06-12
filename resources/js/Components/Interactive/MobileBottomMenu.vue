<script setup>
	import Container from '@/Components/Container.vue'
	import IconSki from '@/Components/IconSki.vue'
	import { Link } from '@inertiajs/vue3'
	import IconTransfer from '@/Components/Icons/IconTransfer.vue'
	import IconProfile from '@/Components/Icons/IconProfile.vue'
	import IconBell from '@/Components/Icons/IconBell.vue'
</script>

<template>
	<div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-20 md:hidden">
		<Container>
			<div class="flex justify-between items-center">
				<Link
					:href="route('instructors.list')"
					class="flex flex-col items-center p-2 hover:bg-gray-100"
				>
					<IconSki class="w-6 h-6" />
					<span class="text-xs">Инструкторы</span>
				</Link>
				<Link
					:href="route('account.index')"
					class="flex flex-col items-center p-2 hover:bg-gray-100"
				>
					<IconProfile class="w-4 h-6" />
					<span class="text-xs">Аккаунт</span>
				</Link>
				<Link
					:href="route('transfer.index')"
					class="flex flex-col items-center p-2 hover:bg-gray-100"
				>
					<IconTransfer class="w-5 h-6" />
					<span class="text-xs">Трансфер</span>
				</Link>
				<Link
					:href="route('account.notifications.index')"
					class="flex flex-col items-center p-2 hover:bg-gray-100"
				>
					<IconBell class="w-6 h-6" />
					<span class="text-xs">Уведомления</span>
				</Link>
			</div>
		</Container>
	</div>
</template>
