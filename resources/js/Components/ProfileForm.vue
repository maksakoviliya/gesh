<script setup>
	import ProfileFormItem from '@/Components/ProfileFormItem.vue'
	import { ref } from 'vue'

	defineProps({
		user: Object,
	})

	const active = ref(null)

	const setActive = (value) => {
		active.value = value
	}
</script>
<template>
	<div class="flex flex-col gap-3">
		<ProfileFormItem
			:disabed="active !== 'name'"
			label="Имя"
			@onActivation="setActive('name')"
			:value="user.data.name"
		/>
		<ProfileFormItem
			:disabed="active !== 'email'"
			label="Email"
			@onActivation="setActive('email')"
			:value="user.data.email ?? 'Укажите email'"
		/>
		<ProfileFormItem
			:disabed="active !== 'phone'"
			label="Телефон"
			@onActivation="setActive('phone')"
			:value="user.data.phone ?? 'Укажите номер телефона'"
		/>
	</div>
</template>
