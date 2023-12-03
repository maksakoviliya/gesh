<script setup>
import {computed, ref} from "vue";

import {OhVueIcon, addIcons} from 'oh-vue-icons'
import {HiX} from 'oh-vue-icons/icons'
import ButtonComponent from "@/Components/ButtonComponent.vue";

addIcons(HiX)

const emit = defineEmits([
    'onClose',
    'onSubmit',
    'onSecondaryAction'
])

const props = defineProps({
        isOpen: {
            type: Boolean
        },
        title: String,
        actionLabel: String,
        disabled: Boolean,
        secondaryActionLabel: String,
    }
)

const showModal = computed(() => {
    return props.isOpen
})
const handleClose = () => {
    if (props.disabled) {
        return;
    }

    emit('onClose')
}

const handleSubmit = () => {
    if (props.disabled) {
        return;
    }

    emit('onSubmit')
}

const handleSecondaryAction = () => {
    if (props.disabled) {
        return;
    }

    emit('onSecondaryAction')
}
</script>

<template>
    <Transition name="fade">
        <div
            v-if="showModal"
            class="
          justify-center
          items-center
          flex
          overflow-x-hidden
          overflow-y-auto
          fixed
          inset-0
          z-50
          outline-none
          focus:outline-none
          bg-neutral-800/70
        "
        >
            <div class="
          relative
          w-full
          md:w-4/6
          lg:w-3/6
          xl:w-2/5
          my-6
          mx-auto
          h-full
          lg:h-auto
          md:h-auto
          "
            >
                <div :class="`
                 translate
                 duration-300
                 h-full
                 ${showModal ?
            'translate-y-0' : 'translate-y-full'}
            ${showModal ? 'opacity-100' : 'opacity-0'}
            `">
                    <div class="
              translate
              h-full
              lg:h-auto
              md:h-auto
              border-0
              rounded-lg
              shadow-lg
              relative
              flex
              flex-col
              w-full
              bg-white
              outline-none
              focus:outline-none
            "
                    >
                        <div class="
                flex
                items-center
                p-6
                rounded-t
                justify-center
                relative
                border-b
                "
                        >
                            <button
                                class="
                    p-1
                    border-0
                    hover:opacity-70
                    transition
                    absolute
                    left-9
                  "
                                @click="handleClose"
                            >
                                <OhVueIcon
                                    name="hi-x"
                                />
                            </button>
                            <div class="text-lg font-semibold pl-16 md:pl-0">
                                {{ title }}
                            </div>
                        </div>
                        <div class="relative p-6 flex-auto">
                            <slot name="body"/>
                        </div>
                        <div class="flex flex-col gap-2 p-6 border-t">
                            <div
                                class="
                    flex
                    flex-row
                    items-center
                    gap-4
                    w-full
                  "
                            >
                                <ButtonComponent
                                    v-if="secondaryActionLabel"
                                    :disabled="disabled"
                                    :label="secondaryActionLabel"
                                    :onClick="handleSecondaryAction"
                                    :outline="true"
                                />
                                <ButtonComponent
                                    :disabled="disabled"
                                    :label="actionLabel"
                                    @click="handleSubmit"
                                />
                            </div>
                            <slot name="footer"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

