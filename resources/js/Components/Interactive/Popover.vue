<script setup>
	import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
	import { computed } from 'vue'

	const props = defineProps({
		maxWidthClass: {
			type: String,
			default: 'max-w-xs',
		},
		position: {
			type: [String, null],
			default: 'center',
		},
		panelClass: {
			type: String,
			default:
				'fixed md:absolute inset-0 md:bottom-auto md:h-auto md:top-full h-screen overflow-auto  mt-3 w-screen z-20 transform md:overflow-visible sm:pr-0 dark:bg-slate-800',
		},
	})

	const positionClass = computed(() => {
		switch (props.position) {
			case 'center':
				return 'md:left-1/2 md:-translate-x-1/2'
			case 'left':
				return 'md:right-0 md:left-auto'
		}
	})
</script>

<template>
	<Popover
		class="relative"
		v-slot="{ open }"
	>
		<PopoverButton class="outline-none">
			<slot
				name="toggle"
				:open="open"
			/>
		</PopoverButton>

		<transition
			enter-active-class="transition duration-200 ease-out"
			enter-from-class="translate-y-1 opacity-0"
			enter-to-class="translate-y-0 opacity-100"
			leave-active-class="transition duration-150 ease-in"
			leave-from-class="translate-y-0 opacity-100"
			leave-to-class="translate-y-1 opacity-0"
		>
			<PopoverPanel :class="[props.maxWidthClass, positionClass, props.panelClass]">
				<div class="h-full overflow-auto rounded-lg shadow-lg dark:shadow-xl ring-1 ring-black/5">
					<slot name="content" />
				</div>
			</PopoverPanel>
		</transition>
	</Popover>
</template>
