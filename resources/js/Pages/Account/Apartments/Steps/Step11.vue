<script setup>
	import Form from '@/Pages/Account/Apartments/Form.vue'
	import { router, useForm } from '@inertiajs/vue3'
	import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

	const props = defineProps({
		apartment: Array | Object,
	})

	const form = useForm({
		fast_reserve: props.apartment.data.fast_reserve ?? true,
	})

	const submit = () => {
		form.transform((data) => ({
			...data,
			step: 11,
		})).post(
			route('account.apartments.store', {
				apartment: props.apartment.data.id,
			})
		)
	}
</script>

<template>
	<Form
		:step="11"
		@onNextStep="submit"
		:edit="props.apartment.data.status === 'published'"
		@onPrevStep="
			router.visit(
				route('account.apartments.step', {
					apartment: apartment.data.id,
					step: 10,
				})
			)
		"
	>
		<div class="mt-0 md:mt-32 max-w-md mx-auto w-full pb-32">
			<div class="flex items-center gap-6 mx-auto">
				<SwitchGroup>
					<Switch
						v-model="form.fast_reserve"
						:class="form.fast_reserve ? 'bg-sky-600' : 'bg-gray-200'"
						class="relative inline-flex h-[38px] w-[74px] shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
					>
						<span
							aria-hidden="true"
							:class="form.fast_reserve ? 'translate-x-9' : 'translate-x-0'"
							class="pointer-events-none inline-block h-[34px] w-[34px] transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
						/>
					</Switch>
					<SwitchLabel class="cursor-pointer flex flex-col">
						<div class="text-xl font-semibold leading-tight text-neutral-800 dark:text-slate-300">
							Быстрое бронирование {{ form.fast_reserve ? 'включено' : 'выключено' }}
						</div>
						<div class="text-gray-600 leading-tight dark:text-slate-400">Быстрое бронирование</div>
					</SwitchLabel>
				</SwitchGroup>
			</div>
		</div>
	</Form>
</template>
