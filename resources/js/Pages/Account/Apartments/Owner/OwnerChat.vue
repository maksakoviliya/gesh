<script setup>
	import Container from '@/Components/Container.vue'
	import Heading from '@/Components/Heading.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Avatar from '@/Components/Avatar.vue'
	import ReservationRequest from '@/Components/Chat/ReservationRequest.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import Message from '@/Components/Chat/Message.vue'
	import TextareaInput from '@/Components/Inputs/TextareaInput.vue'
	import EmptyState from '@/Components/EmptyState.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import { ref } from 'vue'
	import Breadcrumbs from '@/Components/Breadcrumbs.vue'

	const props = defineProps({
		chats: {
			type: Object,
		},
		messages: {
			type: [Object, null],
		},
		chat: {
			type: [Object, null],
		},
		apartment: {
			type: Object,
		},
	})

	const selectChat = (chat) => {
		router.visit(
			route('account.apartments.owner.chat', {
				chat: chat.id,
				apartment: chat.apartment.id,
			})
		)
	}

	const form = useForm({
		message: '',
	})

	const submit = () => {
		form.post(
			route('account.chat.messages.store', {
				chat: props.chat.data.id,
			}),
			{
				preserveScroll: true,
				onSuccess: () => form.reset('message'),
			}
		)
	}

	const routes = ref([
		{
			id: 'account',
			route: route('account.index'),
			label: 'Аккаунт',
		},
		{
			id: 'apartments',
			route: route('account.apartments.list'),
			label: 'Мои объекты',
		},
		{
			id: 'chat',
			route: route('account.apartments.list'),
			label: 'Чаты',
		},
	])
</script>

<template>
	<AppLayout>
		<Container>
			<Breadcrumbs :routes="routes" />
			<Heading
				class="mt-8"
				title="Чат объекта"
			/>

			<div
				class="mt-6 flex flex-col items-start md:flex-row gap-4 md:justify-between relative md:min-h-0 min-h-[600px] h-[70vh]"
			>
				<div class="w-full md:w-2/3 h-full relative">
					<div
						v-if="props.chat && props.messages?.data?.length"
						class="absolute inset-x-0 top-0 bottom-32 overflow-auto flex flex-col items-start gap-1.5"
					>
						<component
							:is="!!message.reservation_request ? ReservationRequest : Message"
							is-owner
							:item="!!message.reservation_request ? message.reservation_request : message"
							v-for="message in props.messages.data"
							:key="message.id"
						/>
					</div>
					<EmptyState
						v-else
						:title="props.chat ? 'Сообщений пока нет' : 'Выберите чат'"
						:subtitle="props.chat ? 'Напишите первым!' : 'И одобрите запрос на бронирование'"
					/>
					<div
						class="absolute inset-x-0 bottom-0 flex items-start gap-3"
						v-if="props.chat"
					>
						<TextareaInput
							v-model="form.message"
							id="message"
							label="Сообщение"
							@onEnter="submit"
						/>
						<ButtonComponent
							:auto-width="true"
							@click="submit"
							class="px-4"
							:outline="true"
							label=""
						>
							<template #icon>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									class="w-6 h-6"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
									/>
								</svg>
							</template>
						</ButtonComponent>
					</div>
				</div>
				<div
					class="block divide-y divide-gray-100 w-full md:w-1/3 md:sticky md:top-24 rounded-xl overflow-hidden shadow-xl h-auto py-2 border border-gray-50"
				>
					<div class="h-full overflow-auto min-h-[300px] md:min-h-0">
						<div
							v-for="chat in props.chats.data"
							:key="chat.id"
							@click="selectChat(chat)"
							class="gap-2 px-4 py-2 cursor-pointer flex flex-col w-full hover:bg-gray-100 dark:hover:bg-slate-600 transition"
							:class="props.chat?.data.id === chat.id ? 'bg-gray-100 dark:bg-slate-700' : ''"
						>
							<div class="flex items-center gap-2">
								<Avatar :src="chat.user.avatar" />
								<div class="flex flex-col">
									<div class="text-sm font-bold text-neutral-800 dark:text-white">
										{{ chat.user.name }}
									</div>
									<div
										class="text-sm font-light text-neutral-500"
										v-if="!chat.last_message?.reservation_request"
									>
										{{ chat.last_message?.message }}
									</div>
								</div>
							</div>
							<div v-if="!!chat.last_message?.reservation_request">
								<ReservationRequest
									compact
									:item="chat.last_message?.reservation_request"
								/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
