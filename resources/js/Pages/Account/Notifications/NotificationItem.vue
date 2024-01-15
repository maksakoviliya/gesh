<script setup>
	import { Link, router } from '@inertiajs/vue3'
	import Avatar from '@/Components/Avatar.vue'

	const props = defineProps({
		notification: {
			type: Object,
			required: true,
		},
	})

	const markNotificationAsRead = (id) => {
		router.visit(
			route('account.notifications.read', {
				notification: id,
			}),
			{
				method: 'post',
				only: ['notifications'],
			}
		)
	}

	const emit = defineEmits(['click'])
</script>

<template>
	<div
		class="relative overflow-x-auto shadow-md cursor-pointer flex flex-col md:flex-row items-start md:items-center transition hover:bg-gray-100 justify-between px-6 py-4 sm:rounded-lg text-sm text-left text-gray-500 dark:text-gray-400"
		@click="emit('click')"
	>
		<div>
			<slot>
				<div class="flex items-baseline gap-1">
					<div class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
						<slot name="title">
							{{ notification.title }}
						</slot>
					</div>
					<div class="text-neutral-400 text-xs">| {{ notification.created_at }}</div>
				</div>
				<div class="flex flex-wrap items-center gap-1 mt-2">
					<slot name="content"></slot>
				</div>
			</slot>
		</div>
		<button
			v-if="!notification.read_at"
			class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
			@click.prevent.stop="markNotificationAsRead(notification.id)"
		>
			Прочитать
		</button>
	</div>
</template>
