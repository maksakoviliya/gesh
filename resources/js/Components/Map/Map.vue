<script setup>
	import { ref, onMounted, onUnmounted } from 'vue'
	import { loadYmap, ymapMarker } from 'vue-yandex-maps'

	const props = defineProps({
		lat: {
			type: [Number, String],
			required: true,
		},
		lon: {
			type: [Number, String],
			required: true,
		},
		isInput: {
			type: Boolean,
			default: true,
		},
		markers: {
			type: [Array],
			default: () => [],
		},
	})

	const emit = defineEmits(['updateLon', 'updateLat'])

	const center = ref([props.lat, props.lon])

	const mapElement = ref(null)
	const map = ref(null)

	const yandexMapInit = async () => {
		if (!mapElement.value) {
			return
		}
		await loadYmap({
			apiKey: '4b6179ba-b733-4d2b-af35-b06f33fc0141',
			lang: 'ru_RU',
			coordorder: 'latlong',
			enterprise: false,
			version: '2.1',
			debug: true,
		})

		const ymapControls = ['zoomControl']

		map.value = new globalThis.ymaps.Map(mapElement.value, {
			center: center.value,
			zoom: 11,
			controls: ymapControls,
		})

		props.markers.map((mark) => {
			const placemark = new globalThis.ymaps.Placemark([mark.lat, mark.lon])
			map.value.geoObjects.add(placemark)
		})

		map.value.events.add('boundschange', function (event) {
			const newCenter = event.get('newCenter')
			emit('updateLat', newCenter[0])
			emit('updateLon', newCenter[1])
		})
	}

	const clearMap = () => {
		if (!mapElement.value) {
			return
		}

		for (let index = 0; mapElement.value.children.length; index++) {
			mapElement.value.children[0]?.remove()
		}

		map.value = null
	}

	onMounted(async () => {
		await yandexMapInit()
	})

	onUnmounted(() => {
		clearMap()
	})

	import { HiLocationMarker } from 'oh-vue-icons/icons'
	import { OhVueIcon, addIcons } from 'oh-vue-icons'

	addIcons(HiLocationMarker)

	const isDragging = ref(false)
	const setIsDragging = (value) => {
		isDragging.value = value
	}
</script>
<template>
	<div class="h-50vh overflow-hidden rounded-xl relative shadow-lg">
		<div
			ref="mapElement"
			style="height: 450px"
		/>
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
