<script setup lang="ts">
	import { computed, ref, shallowRef } from 'vue'
	import type { YMap } from '@yandex/ymaps3-types'
	import { HiLocationMarker } from 'oh-vue-icons/icons'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'

	import {
		YandexMap,
		YandexMapClusterer,
		YandexMapControls,
		YandexMapDefaultFeaturesLayer,
		YandexMapDefaultSchemeLayer,
		YandexMapListener,
		YandexMapMarker,
		YandexMapZoomControl,
	} from 'vue-yandex-maps'
	import { router } from '@inertiajs/vue3'

	const map = shallowRef<null | YMap>(null)

	const props = defineProps({
		lon: {
			type: [String, Number, null],
			default: 87.98709856259356,
		},
		lat: {
			type: [String, Number, null],
			default: 52.92596754124867,
		},
		markers: {
			type: Array,
			default: () => [],
		},
		isInput: {
			type: Boolean,
			default: true,
		},
	})

	const center = [props.lat, props.lon]

	const emit = defineEmits(['updateLon', 'updateLat'])
	const handleChange = (object) => {
		emit('updateLat', map.value.center[0])
		emit('updateLon', map.value.center[1])
	}

	addIcons(HiLocationMarker)

	const darkMode = ref(document.documentElement.classList.contains('dark'))
	const theme = computed(() => {
		return 'light'
		// return darkMode ? 'dark' : 'light'
	})
</script>

<template>
	<div class="h-[60vh] max-h-screen overflow-hidden rounded-xl relative shadow-lg">
		<YandexMap
			v-model="map"
			:settings="{
				location: {
					center,
					zoom: 13,
				},
			}"
			width="100%"
			height="100%"
		>
			<yandex-map-listener :settings="{ onUpdate: handleChange }" />
			<yandex-map-controls :settings="{ position: 'right' }">
				<yandex-map-zoom-control />
			</yandex-map-controls>
			<yandex-map-default-scheme-layer
				:settings="{
					theme: theme,
				}"
			/>

			<yandex-map-default-features-layer />
			<yandex-map-clusterer>
				<yandex-map-marker
					v-for="marker in props.markers"
					:settings="{ coordinates: marker.center }"
					:key="marker.img"
					@click.prevent="
						router.visit(
							route('apartment', {
								apartment: marker.id,
							})
						)
					"
				>
					<div class="w-12 h-12 rounded-full overflow-hidden bg-white p-1 cursor-pointer group">
						<img
							alt="marker.img"
							class="w-full h-full object-cover rounded-full group-hover:scale-110 transition"
							:src="marker.img"
							@click="map?.setLocation({ center: marker.center, zoom: 12, duration: 400 })"
						/>
					</div>
				</yandex-map-marker>

				<template #cluster="{ coordinates, length }">
					<div class="bg-white p-1 rounded-full w-12 h-12 cursor-pointer">
						<div
							class="rounded-full w-full h-full flex items-center justify-center font-semibold text-neutral-800 bg-gray-200"
						>
							{{ length }}
						</div>
					</div>
				</template>
			</yandex-map-clusterer>
		</YandexMap>

		<div
			class="absolute bottom-1/2 left-1/2 -translate-x-1/2 text-sky-500"
			v-if="props.isInput"
		>
			<OhVueIcon
				name="hi-location-marker"
				scale="2.8"
			/>
		</div>
	</div>
</template>
