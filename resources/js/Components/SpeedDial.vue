<script setup>
	import { onMounted } from 'vue'
	import { initFlowbite } from 'flowbite'
	import { HiChat } from 'oh-vue-icons/icons'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	addIcons(HiChat)

	onMounted(() => {
		initFlowbite()
	})
</script>

<template>
	<div
		data-dial-init
		class="fixed end-3 md:end-10 bottom-8 group"
	>
		<div
			id="speed-dial-menu-default"
			class="flex-col items-center hidden mb-4 space-y-2"
		>
			<button
				type="button"
				data-tooltip-target="tooltip-share"
				data-tooltip-placement="left"
				class="flex justify-center items-center w-10 h-10 md:w-14 md:h-14 text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400"
			>
				<OhVueIcon
					name="hi-chat"
					scale="1.3"
				/>
				<span class="sr-only">Сообщения</span>
			</button>
			<div
				id="tooltip-share"
				role="tooltip"
				class="absolute z-10 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
			>
				Сообщения
				<div
					class="tooltip-arrow"
					data-popper-arrow
				></div>
			</div>
		</div>
		<button
			type="button"
			data-dial-toggle="speed-dial-menu-default"
			aria-controls="speed-dial-menu-default"
			aria-expanded="false"
			class="flex items-center justify-center text-white shadow-lg bg-sky-700 rounded-full w-10 h-10 md:w-14 md:h-14 hover:bg-sky-600 dark:bg-sky-600 dark:hover:bg-sky-700 outline-none"
		>
			<svg
				class="w-4 h-4 transition-transform group-hover:rotate-45"
				aria-hidden="true"
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 18 18"
			>
				<path
					stroke="currentColor"
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M9 1v16M1 9h16"
				/>
			</svg>
			<span class="sr-only">Open actions menu</span>
		</button>
	</div>
</template>
