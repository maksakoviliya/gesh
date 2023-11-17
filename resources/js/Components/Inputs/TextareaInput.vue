<script setup>
defineProps({
    id: String,
    label: String,
    type: String | null,
    error: String | null,
    disabled: Boolean | null,
    required: Boolean | null,
    modelValue: String
})
</script>

<template>
    <form class="w-full relative" autocomplete="off">
        <!--        {formatPrice && (-->
        <!--        <BiDollar-->
        <!--            size={24}-->
        <!--            class="-->
        <!--            text-neutral-700-->
        <!--            absolute-->
        <!--            top-5-->
        <!--            left-2-->
        <!--          "-->
        <!--        />-->
        <!--        )}-->
        <textarea
            :id="id"
            :disabled="disabled"
            placeholder=" "
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :type="type ?? 'text'"
            autocomplete="new-password"
            class="
            peer
            w-full
            p-4
            pt-6
            font-light
            bg-white
            border-2
            rounded-md
            shadow-none
            outline-none
            transition
            disabled:opacity-70
            focus:ring-0
            resize-none
           pl-4
            disabled:cursor-not-allowed"
            :class="`
                    ${error ? 'border-rose-500' : 'border-neutral-300'}
                ${error ? 'focus:border-rose-500' : 'focus:border-black'}
            `"
        />

        <!--        ${formatPrice ? 'pl-9' : 'pl-4'}-->
        <!--        `}-->
        <label
            class="
            absolute
            text-md
            duration-150
            transform
            -translate-y-3
            scale-75
            top-5
            left-4
            z-10
            origin-[0]
            peer-placeholder-shown:scale-100
            peer-placeholder-shown:translate-y-0
            peer-focus:scale-75
            peer-focus:-translate-y-4
        "
            :class="error ? 'text-rose-500' : 'text-zinc-400'"
        >
            {{ label }}
        </label>
        <div v-if="!!error" class="text-rose-500 text-sm font-light">{{ error}}</div>
    </form>
</template>

