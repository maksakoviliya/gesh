<script setup>
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
</script>

<template>
    <Popover class="relative">
        <PopoverButton class="outline-none"
        >
            <slot name="toggle" />
        </PopoverButton>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-1 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-1 opacity-0"
        >
            <PopoverPanel
                class="absolute left-0 lg:left-1/2 mt-3 w-screen max-w-xs z-10 lg:-translate-x-1/2 transform pr-4 sm:pr-0"
            >
                <div
                    class="overflow-hidden bg-white h-full rounded-lg shadow-lg ring-1 ring-black/5"
                >
                    <slot name="content" />
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>
