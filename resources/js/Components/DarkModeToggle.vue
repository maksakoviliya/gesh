<script setup>
	import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'
	import { ref, watch } from 'vue'

	const darkMode = ref(
		localStorage.getItem('color-theme') === 'dark' || document.documentElement.classList.contains('dark')
	)
	watch(darkMode, (val) => {
		// if set via local storage previously
		if (localStorage.getItem('color-theme')) {
			if (localStorage.getItem('color-theme') === 'light') {
				document.documentElement.classList.add('dark')
				localStorage.setItem('color-theme', 'dark')
			} else {
				document.documentElement.classList.remove('dark')
				localStorage.setItem('color-theme', 'light')
			}

			// if NOT set via local storage previously
		} else {
			if (document.documentElement.classList.contains('dark')) {
				document.documentElement.classList.remove('dark')
				localStorage.setItem('color-theme', 'light')
			} else {
				document.documentElement.classList.add('dark')
				localStorage.setItem('color-theme', 'dark')
			}
		}
	})
</script>

<template>
	<SwitchGroup
		as="div"
		class="flex items-center gap-3 text-neutral-500"
	>
		<SwitchLabel
			class="cursor-pointer flex flex-col"
			:class="!darkMode ? 'text-neutral-800 dark:text-slate-300' : ''"
		>
			<svg
				id="theme-toggle-light-icon"
				class="w-5 h-5"
				fill="currentColor"
				viewBox="0 0 20 20"
				xmlns="http://www.w3.org/2000/svg"
			>
				<path
					d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
					fill-rule="evenodd"
					clip-rule="evenodd"
				></path>
			</svg>
		</SwitchLabel>
		<Switch
			v-model="darkMode"
			:class="darkMode ? 'bg-sky-600' : 'bg-gray-200'"
			class="relative inline-flex h-6 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
		>
			<span
				aria-hidden="true"
				:class="darkMode ? 'translate-x-4' : 'translate-x-0'"
				class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
			/>
		</Switch>
		<SwitchLabel
			class="cursor-pointer flex items-center gap-1"
			:class="darkMode ? 'text-neutral-800 dark:text-slate-200' : ''"
		>
			<svg
				class="w-5 h-5"
				fill="currentColor"
				viewBox="0 0 20 20"
				xmlns="http://www.w3.org/2000/svg"
			>
				<path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
			</svg>
			<div class="text-xs leading-none text-neutral-500 dark:text-slate-200">Темная тема</div>
		</SwitchLabel>
	</SwitchGroup>
</template>
