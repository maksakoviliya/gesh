<script setup>
import Button from "@/Components/ButtonComponent.vue"

defineProps({
    actionLabel: String,
    handleSubmit: Function
})
</script>

<template>
    <div
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
            <div class="
                 translate
                 duration-300
                 h-full"
            >
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
                border-b-[1px]
                "
                    >
                        <div class="text-lg font-semibold">
                            <slot name="title">
                                {Title}
                            </slot>
                        </div>
                    </div>
                    <div class="relative p-6 flex-auto">
                        <slot name="body">
                            {body}
                        </slot>
                    </div>
                    <div class="flex flex-col gap-2 p-6">
                        <div
                            class="
                    flex
                    flex-row
                    items-center
                    gap-4
                    w-full
                  "
                        >
                            <!--                            {secondaryAction && secondaryActionLabel && (-->
                            <!--                            <Button-->
                            <!--                                disabled={disabled}-->
                            <!--                                label={secondaryActionLabel}-->
                            <!--                                onClick={handleSecondaryAction}-->
                            <!--                                outline-->
                            <!--                            />-->
                            <!--                            )}-->
                            <Button
                                :label="actionLabel"
                                @click="handleSubmit"
                            />
                        </div>
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
]
