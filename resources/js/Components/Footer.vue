<script setup>
	import Container from '@/Components/Container.vue'
	import { Link } from '@inertiajs/vue3'
</script>

<template>
	<footer class="absolute bottom-0 w-full bg-white dark:bg-slate-800 border-t dark:border-slate-700">
		<Container class="py-6 lg:py-8">
			<div class="flex flex-col md:flex-row gap-6 sm:items-center sm:justify-between">
				<span class="text-sm text-gray-500 sm:text-center dark:text-gray-400"
					>© {{ new Date().getFullYear() }}
					<Link
						:href="route('home')"
						class="hover:underline"
						>gesh-resort.online</Link
					>
				</span>
				<div
					class="text-gray-500 dark:text-gray-400 font-medium flex flex-col sm:flex-row sm:items-end md:items-center gap-3 md:gap-6 lg:gap-6"
				>
					<Link
						:href="route('policy')"
						class="hover:underline"
						>Политика конфиденциальности</Link
					>
					<Link
						:href="route('rules')"
						class="hover:underline"
						>Правила пользования</Link
					>
				</div>
			</div>
		</Container>
	</footer>
</template>
