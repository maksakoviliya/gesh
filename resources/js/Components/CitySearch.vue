<script setup>
	import Input from '@/Components/Input.vue'
	import { useForm } from '@inertiajs/vue3'
	import debounce from 'lodash.debounce'
	import { ref } from 'vue'

	const props = defineProps({
		query: {
			required: false,
			type: [String, null],
			default: null,
		},
	})

	const form = useForm({
		query: props.query,
	})

	const emit = defineEmits(['select'])

	const cities = ref([])

	const loading = ref(false)

	const onSearch = debounce(async (value) => {
		if (value === form.query) {
			return
		}
		loading.value = true
		form.query = value
		if (!form.query) {
			loading.value = false
			return
		}
		axios
			.post(
				route('search.city', {
					query: form.query,
				})
			)
			.then((res) => {
				const data = res.data?.data
				if (data) {
					cities.value = data
				}
			})
			.finally(() => {
				loading.value = false
			})
	}, 300)

	const onSelect = (value) => {
		onSearch(value)
		emit('select', value)
	}
</script>
<template>
	<div class>
		<Input
			id="city_search"
			:model-value="form.query"
			@update:model-value="onSearch"
			label="Город"
		/>
		<div
			class="mt-2"
			v-if="!loading"
		>
			<div
				v-if="!form.query"
				class="text-neutral-400 font-light leading-tight"
			>
				Начните вводить город, или оставьте пустым
			</div>
			<div
				v-else-if="cities.length"
				class="font-light leading-tight flex flex-col gap-2"
			>
				<div
					@click="onSelect(city)"
					v-for="city in cities"
					class="cursor-pointer flex items-center gap-2 text-neutral-600 hover:text-neutral-800 transition"
				>
					{{ city }}
				</div>
			</div>
			<div v-else>Городов не найдено</div>
		</div>
	</div>
</template>
