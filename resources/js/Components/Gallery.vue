<script setup>
	import { computed, ref } from 'vue'
	import { Dialog, DialogPanel, TransitionRoot, TransitionChild } from '@headlessui/vue'

	import { OhVueIcon, addIcons } from 'oh-vue-icons'
	import { HiSolidX } from 'oh-vue-icons/icons'
	addIcons(HiSolidX)

	const props = defineProps({
		images: {
			type: Array,
			default: [],
		},
	})

	const imagesLimited = computed(() => {
		return props.images.slice(0, 4)
	})

	const getImageWrapperClasses = (index) => {
		let result = []
		if (index === 0) {
			result.push('row-span-2', imagesLimited.value.length <= 1 ? 'col-span-full' : 'col-span-2')
		}
		if (index === 1) {
			result.push(
				imagesLimited.value.length <= 3 ? 'row-span-2' : '',
				imagesLimited.value.length <= 2 ? 'col-span-2' : ''
			)
		}
		if (index === 2) {
			result.push(
				imagesLimited.value.length <= 4 ? 'row-span-2' : '',
				'row-span-2',
				imagesLimited.value.length <= 3 ? 'col-span-1' : ''
			)
		}
		return result.join(' ')
	}

	const isOpen = ref(false)
	const openAllPhotos = (value) => {
		isOpen.value = value
	}
</script>

<template>
	<div
		class="rounded-xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-2 md:max-h-72 gap-1 overflow-hidden"
	>
		<div
			@click="openAllPhotos(true)"
			class="group overflow-hidden"
			:class="getImageWrapperClasses(i)"
			v-for="(img, i) in imagesLimited"
		>
			<img
				:src="img.src"
				class="object-cover w-full h-full transition cursor-pointer group-hover:scale-110"
				alt=""
			/>
		</div>

		<TransitionRoot
			:show="isOpen"
			as="template"
		>
			<Dialog
				:open="isOpen"
				@close="openAllPhotos(false)"
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
							<DialogPanel class="w-full max-w-7xl rounded-xl p-6 bg-white relative flex">
								<div class="grid gap-4 grid-cols-1 md:grid-cols-2">
									<div
										class="cursor-pointer md:[&:nth-child(3n)]:col-span-2"
										v-for="image in props.images"
										:key="image.id"
									>
										<img
											class="w-full h-full object-cover"
											:src="image.src"
											alt=""
										/>
									</div>
								</div>
							</DialogPanel>
						</TransitionChild>
						<div
							@click="openAllPhotos(false)"
							class="sticky top-4 aspect-square w-6 md:w-16 h-6 md:h-16 bg-white flex flex-col items-center justify-center rounded-full hover:bg-gray-100 cursor-pointer"
						>
							<OhVueIcon name="hi-solid-x" />
						</div>
					</div>
				</div>
			</Dialog>
		</TransitionRoot>
	</div>
</template>
