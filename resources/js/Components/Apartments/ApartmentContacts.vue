<script setup>
	import AdminContacts from '@/Components/Apartments/AdminContacts.vue'

	const props = defineProps({
		apartment: {
			type: Object,
			required: true,
		},
		owner: {
			type: Object,
			required: true,
		},
	})
</script>

<template>
	<div class="flex flex-col gap-3 mt-5 text-neutral-900 dark:text-neutral-200">
		<h4 class="text-xl font-semibold">Контакты:</h4>
		<template v-if="props.apartment.is_visible">
			<a
				class="group"
				:href="`tel:${props.owner.phone}`"
				v-if="props.owner.phone"
			>
				Телефон:
				<span class="group-hover:underline text-sky-600">{{ props.owner.phone }}</span>
			</a>
			<a
				class="group"
				:href="`https://t.me/${props.owner.telegram_username}`"
				v-if="props.owner.telegram_username"
			>
				Телеграм:
				<span class="group-hover:underline text-sky-600">@{{ props.owner.telegram_username }}</span>
			</a>
		</template>
		<AdminContacts
			:apartment-id="props.apartment.id"
			v-else
		/>
	</div>
</template>
