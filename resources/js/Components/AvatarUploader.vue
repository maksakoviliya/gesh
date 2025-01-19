<script setup>
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { CoPencil } from 'oh-vue-icons/icons'
	import { ref } from 'vue'
	//
	addIcons(CoPencil)

	const props = defineProps({
		src: {
			required: true,
		},
	})

	const avatar = ref(props.src ?? '/img/no-user.svg')
</script>

<template>
	<div class="w-full relative group">
		<div class="rounded-full overflow-hidden w-40 aspect-square mx-auto">
			<img
				class="w-full object-cover"
				:src="avatar"
				alt="Avatar"
			/>
		</div>
		<div
			class="absolute opacity-0 bottom-0 left-1/2 -translate-x-1/2 bg-sky-600 hover:bg-sky-400 dark:bg-sky-700 dark:hover:bg-sky-600 cursor-pointer transition aspect-square rounded-full w-10 group-hover:opacity-100 flex flex-col items-center justify-center text-white"
		>
			<OhVueIcon
				name="co-pencil"
				scale="1.2"
			/>
		</div>
	</div>
</template>
