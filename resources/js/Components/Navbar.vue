<script setup>
	import { onBeforeMount, onBeforeUnmount, ref } from 'vue'
	import Container from '@/Components/Container.vue'
	import Logo from '@/Components/Logo.vue'
	import Search from '@/Components/Search.vue'
	import UserMenu from '@/Components/UserMenu.vue'

	const lastPos = ref(0)
	const isHidden = ref(false)
	const handleScroll = () => {
		const currentPos = window.pageYOffset
		isHidden.value = currentPos > lastPos.value && currentPos > 80
		lastPos.value = currentPos
	}

	onBeforeMount(() => {
		document.addEventListener('scroll', handleScroll)
	})
	onBeforeUnmount(() => {
		document.removeEventListener('scroll', handleScroll)
	})
</script>

<template>
	<div
		class="fixed w-full bg-white z-20 shadow-sm dark:bg-slate-800 transition"
		:class="isHidden ? '-translate-y-full' : ''"
	>
		<div class="py-4 border-b dark:border-slate-700">
			<Container>
				<div class="flex flex-row items-center justify-between gap-3 md:gap-0">
					<Logo />
					<Search />
					<UserMenu />
				</div>
			</Container>
		</div>
	</div>
</template>
