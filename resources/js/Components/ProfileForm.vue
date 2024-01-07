<script setup>
	import ProfileFormItem from '@/Components/ProfileFormItem.vue'

	defineProps({
		user: Object,
	})
</script>
<template>
	<div class="flex flex-col gap-3">
		<ProfileFormItem
			key="name"
			field="name"
			:url="
				route('account.profile.update', {
					account: user.id,
				})
			"
			label="Имя"
			:value="user.name"
		/>
		<ProfileFormItem
			key="email"
			field="email"
			:url="
				route('account.profile.update', {
					account: user.id,
				})
			"
			label="Email"
			:value="user.email ?? 'Укажите email'"
		/>
		<ProfileFormItem
			key="phone"
			field="phone"
			:url="
				route('account.profile.update', {
					account: user.id,
				})
			"
			label="Телефон"
			:value="user.phone ?? 'Укажите номер телефона'"
		/>
	</div>
</template>
