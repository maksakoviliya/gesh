<script setup>
	import Container from '@/Components/Container.vue'
	import AppLayout from '@/Layouts/AppLayout.vue'
	import { Link, useForm } from '@inertiajs/vue3'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import TextareaInput from '@/Components/Inputs/TextareaInput.vue'
	import Heading from '@/Components/Heading.vue'
	import Message from '@/Components/Chat/Message.vue'
	import ReservationRequest from '@/Components/Chat/ReservationRequest.vue'
	import EmptyState from '@/Components/EmptyState.vue'

	const props = defineProps({
		apartment: {
			type: Object,
		},
		chat: {
			type: Object,
		},
		messages: {
			type: Object,
		},
	})

	const form = useForm({
		message: '',
	})

	const submit = () => {
		form.post(
			route('chat.messages.store', {
				chat: props.chat.data.id,
			}),
			{
				preserveScroll: true,
				onSuccess: () => form.reset('message'),
			}
		)
	}
</script>

<template>
	<AppLayout>
		<Container>
			<Heading
				class="mt-8"
				title="Чат с хозяином"
			/>
			<div class="mt-6 flex flex-col items-start md:flex-row gap-4 md:justify-between relative h-[70vh]">
				<div class="w-full md:w-2/3 h-full relative">
					<div
						v-if="props.messages.data.length"
						class="absolute inset-x-0 top-0 bottom-32 overflow-auto flex flex-col items-start gap-1.5"
					>
						<component
							:is="!!message.reservation_request ? ReservationRequest : Message"
							:item="!!message.reservation_request ? message.reservation_request : message"
							v-for="message in props.messages.data"
							:key="message.id"
						/>
					</div>
					<EmptyState
						v-else
						title="Сообщений пока нет"
						subtitle="Напишите первым!"
					/>
					<div class="absolute inset-x-0 bottom-0 flex items-start gap-3">
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
				<div class="hidden md:block md:w-1/3 md:sticky md:top-24 rounded-lg shadow-xl h-auto p-4">
					<div class="flex items-stretch justify-start gap-4">
						<Link
							:href="
								route('apartment', {
									apartment: props.apartment.data.id,
								})
							"
							class="h-24 w-32 rounded-lg overflow-hidden"
						>
							<img
								:src="props.apartment.data.media[0]?.src"
								class="h-full w-full object-cover"
								alt=""
							/>
						</Link>
						<div class="flex flex-col justify-between">
							<div class="text-gray-600 font-light">
								{{ props.apartment.data.category.title }}
							</div>
							<div class="font-bold">
								{{ props.apartment.data.weekdays_price.toLocaleString() }}₽
								<span class="font-light text-sm text-neutral-500">ночь</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>
