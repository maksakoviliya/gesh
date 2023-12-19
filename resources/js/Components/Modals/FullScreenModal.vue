<script setup>
	import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'

	import { HiSolidX } from 'oh-vue-icons/icons'
	addIcons(HiSolidX)

	const props = defineProps({
		isOpen: {
			type: Boolean,
			default: false,
		},
	})

	const emit = defineEmits(['close'])
</script>
<template>
	<TransitionRoot
		:show="props.isOpen"
		as="template"
	>
		<Dialog
			:open="isOpen"
			@close="emit('close')"
			class="z-50 fixed inset-0"
		>
			<TransitionChild
				enter="duration-300 ease-out"
				enter-from="opacity-0 scale-95"
				enter-to="opacity-100 scale-100"
				leave="duration-200 ease-in"
				leave-from="opacity-100 scale-100"
				leave-to="opacity-0 scale-95"
			>
				<DialogPanel class="absolute inset-0 bg-white">
					<slot />
				</DialogPanel>
			</TransitionChild>
			<button
				type="button"
				@click="emit('close')"
				class="absolute top-4 right-4 aspect-square w-6 md:w-16 h-6 md:h-16 hover:bg-gray-200 flex flex-col items-center justify-center rounded-full bg-gray-100 cursor-pointer"
			>
				<OhVueIcon name="hi-solid-x" />
			</button>
		</Dialog>
	</TransitionRoot>
</template>
