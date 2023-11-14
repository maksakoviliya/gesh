<script setup>
import {computed} from "vue";
import ButtonComponent from "@/Components/ButtonComponent.vue";
import Rooms from "@/Components/Rooms.vue";
import Guests from "@/Components/Guests.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    apartment: Array | Object
})

const image = computed(() => {
    return props.apartment.images?.[0]?.src ?? '/img/no-photo.webp'
})

const handleClick = () => {
    return router.visit(route('apartment', props.apartment.id))
}
</script>

<template>
    <div
        class="col-span-1 cursor-pointer group"
        @click="handleClick"
    >
        <div class="flex flex-col gap-2 w-full">
            <div
                class="
            aspect-square
            w-full
            relative
            overflow-hidden
            rounded-xl
          "
            >
                <img
                    class="
              object-cover
              h-full
              w-full
              group-hover:scale-110
              transition
            "
                    :src="image"
                    :alt="props.apartment.title"
                />
                <div class="
            absolute
            top-3
            right-3
          ">
                    <!--                    <HeartButton-->
                    <!--                        listingId={data.id}-->
                    <!--                        currentUser={currentUser}-->
                    <!--                    />-->
                </div>
            </div>
            <!--            <div class="font-semibold text-lg">-->
            <!--                {location?.region}, {location?.label}-->
            <!--            </div>-->
            <div class="font-light text-neutral-500">
                {{ props.apartment.categories.map(category => category.title).join(', ')}}
            </div>
            <div class="flex flex-row items-center gap-1">
                <div class="font-semibold">
                    {{ props.apartment.price.toLocaleString('ru') }}₽ <span class="text-neutral-500 font-light text-sm">ночь</span>
                </div>
            </div>
            <div class="flex flex-row items-center gap-2">
                <Rooms :rooms="props.apartment.rooms" />
                <Guests :guests="props.apartment.guests" />
            </div>
            <!--            {onAction && actionLabel && (-->
                        <ButtonComponent
                            :small="true"
                            label="Забронировать"
                        />
            <!--            )}-->
        </div>
    </div>
</template>
