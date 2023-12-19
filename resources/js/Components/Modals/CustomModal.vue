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
			class="relative z-50"
		>
			<TransitionChild
				enter="duration-300 ease-out"
				enter-from="opacity-0"
				enter-to="opacity-100"
				leave="duration-200 ease-in"
				leave-from="opacity-100"
				leave-to="opacity-0"
			>
				<div
					class="fixed inset-0 bg-black/30"
					aria-hidden="true"
				/>
			</TransitionChild>

			<div class="fixed inset-0 w-screen overflow-y-auto">
				<!-- Container to center the panel -->
				<div class="flex min-h-full items-start justify-center p-4 md:p-6 xl:p-10 gap-4">
					<TransitionChild
						enter="duration-300 ease-out"
						enter-from="opacity-0 scale-95"
						enter-to="opacity-100 scale-100"
						leave="duration-200 ease-in"
						leave-from="opacity-100 scale-100"
						leave-to="opacity-0 scale-95"
					>
						<DialogPanel class="w-full max-w-5xl rounded-xl p-6 bg-white relative flex">
							<slot />
						</DialogPanel>
					</TransitionChild>
					<button
						type="button"
						@click="emit('close')"
						class="sticky top-4 aspect-square w-6 md:w-16 h-6 md:h-16 bg-white flex flex-col items-center justify-center rounded-full hover:bg-gray-100 cursor-pointer"
					>
						<OhVueIcon name="hi-solid-x" />
					</button>
				</div>
			</div>
		</Dialog>
	</TransitionRoot>
</template>
