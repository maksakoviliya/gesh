<script setup>
	const props = defineProps({
		count: {
			type: [Number, String, null],
		},
		hiddenCount: {
			type: [Boolean],
			default: false,
		},
	})
</script>

<template>
	<div
		v-if="props.count"
		class="absolute inline-flex items-center justify-center w-5 h-5 text-[11px] font-medium text-white bg-red-500 rounded-full -top-1 -end-1"
	>
		<template v-if="!props.hiddenCount">
			{{ props.count }}
		</template>
	</div>
</template>
