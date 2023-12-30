<script setup>
	import { Link } from '@inertiajs/vue3'
	import ServiceBannerLink from '@/Components/ServiceBanner/ServiceBannerLink.vue'
</script>

<template>
	<div class="grid gap-4 grid-cols-1 md:grid-cols-2 border-b dark:border-slate-700 pb-7">
		<ServiceBannerLink
			:href="route('instructors.list')"
			srcset="
						/img/ServicesBanner/Instructors/instructors_w_190.jpg 190w,
						/img/ServicesBanner/Instructors/instructors_w_372.jpg 372w,
						/img/ServicesBanner/Instructors/instructors_w_509.jpg 509w,
						/img/ServicesBanner/Instructors/instructors_w_631.jpg 631w,
						/img/ServicesBanner/Instructors/instructors_w_748.jpg 748w,
						/img/ServicesBanner/Instructors/instructors_w_851.jpg 851w,
						/img/ServicesBanner/Instructors/instructors_w_919.jpg 919w,
						/img/ServicesBanner/Instructors/instructors_w_960.jpg 960w
					"
			src="/img/ServicesBanner/Instructors/instructors_w_960.jpg"
			alt="instructors"
		>
			Инструкторы
		</ServiceBannerLink>
		<ServiceBannerLink
			:href="route('transfer.index')"
			srcset="
                /img/ServicesBanner/Transfer/transfer_w_190.jpg 190w,
                /img/ServicesBanner/Transfer/transfer_w_628.jpg 628w,
                /img/ServicesBanner/Transfer/transfer_w_850.jpg 850w,
                /img/ServicesBanner/Transfer/transfer_w_960.jpg 960w"
			src="/img/ServicesBanner/Transfer/transfer_w_960.jpg"
			alt="transfer"
		>
			Трансфер
		</ServiceBannerLink>
	</div>
</template>
