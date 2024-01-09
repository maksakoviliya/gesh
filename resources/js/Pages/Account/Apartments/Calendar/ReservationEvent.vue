<script setup>
	import { Link, router } from '@inertiajs/vue3'
	import Avatar from '@/Components/Avatar.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'

	const props = defineProps({
		event: Object,
	})

	const goToChat = () => {
		router.visit(
			route('account.apartments.chats', {
				apartment: props.event.data.reservation.apartment_id,
			})
		)
	}
</script>

<template>
	<div class="">
		<div class="flex items-center gap-2">
			<Avatar :src="props.event.data.reservation.user.avatar" />
			<div>
				<div class="font-medium text-sm dark:text-white">
					{{ props.event.data.reservation.user.name }}
				</div>
				<div class="font-medium text-sm dark:text-slate-400">
					{{ props.event.data.reservation.user.email }}
					<span v-if="props.event.data.reservation.user.phone"
						>| {{ props.event.data.reservation.user.phone }}</span
					>
				</div>
			</div>
		</div>
		<div class="text-neutral-800 dark:text-slate-200 mt-2">
			c {{ props.event.data.reservation.start }} по {{ props.event.data.reservation.end }} |
			{{ props.event.data.reservation.range }} ночей | {{ props.event.data.reservation.guests }} гостей
		</div>
		<div class="text-neutral-800 dark:text-white font-semibold mt-4">
			Итого: {{ event.data.reservation.price.toLocaleString() }}₽
		</div>
		<div class="flex items-center gap-4 mt-8">
			<!--			<ButtonComponent-->
			<!--				@click="handle"-->
			<!--				label="Отказать"-->
			<!--				:outline="true"-->
			<!--			/>-->
			<ButtonComponent
				label="К чату"
				@click="goToChat"
			/>
		</div>
	</div>
</template>
