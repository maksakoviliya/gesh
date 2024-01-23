<script setup>
	import Avatar from '@/Components/Avatar.vue'

	const props = defineProps({
		item: {
			type: Object,
			required: true,
		},
	})
</script>

<template>
	<div class="flex items-start gap-2">
		<Avatar :src="props.item.user?.avatar" />
		<div class="flex flex-col">
			<div class="text-sm font-bold dark:text-slate-200">
				<span
					v-if="$page.props.user?.data?.id === props.item.user?.id"
					class="text-neutral-600 dark:text-slate-500"
					>Вы:</span
				>
				{{ props.item.user?.name }}
				<span class="font-light text-xs text-gray-400 dark:text-slate-500">{{ props.item.created_at }}</span>
			</div>
			<div class="dark:text-slate-200">{{ props.item.message }}</div>
		</div>
	</div>
</template>
