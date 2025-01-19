<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue'
	import Container from '@/Components/Container.vue'
	import Gallery from '@/Components/Gallery.vue'
	import Heading from '@/Components/Heading.vue'
	import { computed, onMounted, ref } from 'vue'
	import Counter from '@/Components/Counter.vue'
	import ButtonComponent from '@/Components/ButtonComponent.vue'
	import Avatar from '@/Components/Avatar.vue'
	import { useForm, usePage } from '@inertiajs/vue3'
	import dayjs from 'dayjs'
	import useToasts from '@/hooks/useToasts'
	import Datepicker from '@/Components/Datepicker.vue'
	import Map from '@/Components/Map/Map.vue'
	import Popover from '@/Components/Interactive/Popover.vue'
	import SmallInfoBlock from '@/Components/Blocks/SmallInfoBlock.vue'
	import ApartmentContacts from '@/Components/Apartments/ApartmentContacts.vue'

	const props = defineProps({
		apartment: Array | Object,
		hasICalLinks: Boolean,
		flash: Object,
	})

	const getTitle = () => {
		const category = [
			props.apartment.data.category?.title,
			props.apartment.data.title ?? null,
			props.apartment.data.city,
		]
		return category.filter((item) => !!item).join(', ')
	}

	const getSubtitle = () => {
		const result = [
			`${props.apartment.data.guests} гостей`,
			`${props.apartment.data.bedrooms} спальня`,
			`${props.apartment.data.beds} кровать`,
			`${props.apartment.data.bathrooms} ванная`,
		]
		return result.filter((item) => !!item).join(' · ')
	}

	const page = usePage()

	const form = useForm({
		start: null,
		end: null,
		range: 2,
		guests: page.props.query['guests'] ?? 2,
		children: page.props.query['children'] ?? 0,
	})

	onMounted(() => {
		const startDate = page.props.query['start'] ?? null
		const endDate = page.props.query['end'] ?? null
		if (!startDate && !endDate) {
			return
		}

		const start = dayjs(startDate, 'DD_MM_YYYY')
		const end = dayjs(endDate, 'DD_MM_YYYY')
		form.range = end.diff(start, 'day')
		form.start = start.set('hour', 15).set('minute', 0).toDate()
		form.end = end.set('hour', 12).set('minute', 0).toDate()
	})

	const details = ref([])

	const { errorToast } = useToasts()

	const markers = ref([
		{
			center: [props.apartment.data.lat, props.apartment.data.lon],
			img: props.apartment.data.media[0]?.src,
		},
	])
</script>

<template>
	<AppLayout>
		<Container sm>
			<Gallery
				class="mt-6"
				:images="apartment.data.media"
			/>
			<div class="flex flex-col items-start lg:flex-row gap-6 justify-between mt-6 relative">
				<div class="w-full lg:w-2/3">
					<div class="flex">
						<Heading
							:title="getTitle()"
							:subtitle="getSubtitle()"
						/>
					</div>
					<hr class="my-4 dark:border-slate-600" />
					<div class="flex justify-between items-start gap-x-6">
						<div class="flex flex-col gap-2">
							<div class="flex items-center min-w-0 gap-x-4">
								<Avatar
									:src="props.apartment.data.owner?.avatar"
									class="h-12 w-12 flex-none rounded-full bg-gray-50"
								/>
								<div class="text-sm font-semibold leading-6 text-gray-900 dark:text-slate-100">
									{{ props.apartment.data.owner?.name ?? '-' }}
								</div>
							</div>
						</div>
						<div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
							<p class="text-sm leading-6 text-gray-900 dark:text-slate-200">Владелец</p>
							<p class="mt-1 text-xs leading-5 text-gray-500 dark:text-slate-400">
								На сайте
								<time datetime="2023-01-23T13:23Z">
									{{ props.apartment.data.owner?.since ?? '-' }}
								</time>
							</p>
						</div>
					</div>
					<template v-if="!!props.apartment.data.features.length">
						<hr class="my-4 dark:border-slate-600" />
						<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
							<div
								v-for="feature in props.apartment.data.features"
								:key="feature.id"
								class="flex items-center gap-3"
							>
								<div
									class="text-neutral-800 dark:text-slate-100"
									v-html="feature.icon"
								></div>
								<div class="text-sm text-neutral-500 dark:text-slate-400">{{ feature.title }}</div>
							</div>
						</div>
					</template>
					<!--                    <hr class="my-4"/>-->
					<!--                    <div class="text-xl">-->
					<!--                        {{ props.apartment.data.category?.title }}-->
					<!--                    </div>-->
					<div
						class="mt-4 py-4 border-t dark:border-slate-600 dark:text-slate-400"
						v-if="props.apartment.data.description"
						v-html="props.apartment.data.description"
					></div>
					<div
						class="mt-4 md:py-4 hidden md:block border-t dark:border-slate-600"
						v-if="props.apartment.data.lon && props.apartment.data.lat"
					>
						<Map
							:lon="props.apartment.data.lon"
							:lat="props.apartment.data.lat"
							:is-input="false"
							:markers="markers"
						/>
					</div>
				</div>
				<div class="relative lg:sticky w-full lg:w-1/3 lg:top-28">
					<div
						class="rounded-lg shadow-lg mt-6 border border-neutral-100 dark:border-slate-700 dark:shadow-gray-900 p-6"
					>
						<div class="flex flex-wrap gap-2 xl:gap-4">
							<div class="text-2xl md:text-3xl font-semibold flex items-center gap-2 dark:text-white">
								{{ props.apartment.data.weekdays_price?.toLocaleString() }}₽
								<div
									class="flex flex-col"
									v-if="props.apartment.data.weekdays_price !== props.apartment.data.weekends_price"
								>
									<span
										class="text-neutral-500 dark:text-slate-400 font-light text-sm leading-none whitespace-nowrap"
										>ночь в</span
									>
									<span class="text-neutral-500 dark:text-slate-400 font-light text-sm leading-none"
										>будни</span
									>
								</div>
								<div v-else>
									<span
										class="text-neutral-500 dark:text-slate-400 font-light text-sm leading-none whitespace-nowrap"
										>/ ночь</span
									>
								</div>
							</div>
							<div
								class="text-2xl md:text-3xl font-semibold flex items-center gap-2 dark:text-white"
								v-if="props.apartment.data.weekdays_price !== props.apartment.data.weekends_price"
							>
								{{ props.apartment.data.weekends_price?.toLocaleString() }}₽
								<div class="flex flex-col">
									<span
										class="text-neutral-500 font-light text-sm dark:text-slate-400 leading-none whitespace-nowrap"
										>ночь в</span
									>
									<span class="text-neutral-500 font-light text-sm dark:text-slate-400 leading-none"
										>выходные</span
									>
								</div>
							</div>
						</div>

						<ApartmentContacts
							:apartment="props.apartment.data"
							:owner="props.apartment.data.owner"
						/>
					</div>
				</div>
				<Map
					:lon="props.apartment.data.lon"
					:lat="props.apartment.data.lat"
					:is-input="false"
					:markers="markers"
					class="md:hidden w-full"
				/>
			</div>
		</Container>
	</AppLayout>
</template>
