<script setup lang="ts">
import {OhVueIcon, addIcons} from "oh-vue-icons";
import {HiSolidMenu, HiX} from "oh-vue-icons/icons";
import {computed, ref} from "vue";
import Avatar from "@/Components/Avatar.vue";
import MenuLink from "@/Components/MenuLink.vue";
import {router, usePage} from "@inertiajs/vue3";

addIcons(HiSolidMenu, HiX)

const isOpen = ref(false)
const setIsOpen = (value: Boolean) => {
    isOpen.value = value
}
const toggleOpen = () => {
    setIsOpen(!isOpen.value)
}

const logout = () => {
    router.post(route('logout'));
};

const page = usePage()
const avatar = computed(() => {
  return page.props.user?.data?.avatar ?? null
})
</script>

<template>
    <div class="relative">
        <div class="flex flex-row items-center gap-3">
            <div
                @click="toggleOpen"
                class="
          p-4
          md:py-1
          md:px-2
          border-[1px]
          border-neutral-200
          flex
          flex-row
          items-center
          gap-3
          rounded-full
          cursor-pointer
          hover:shadow-md
          transition
          "
            >
                <OhVueIcon name="hi-solid-menu" v-if="!isOpen"/>
                <OhVueIcon name="hi-x" v-else/>
                <div class="hidden md:block">
                    <Avatar :src="avatar"/>
                </div>
            </div>
        </div>
        <div
            v-if="isOpen"
            class="
                    absolute
                    rounded-xl
                    shadow-md
                    w-[40vw]
                    md:w-[22vw]
                    bg-white
                    overflow-hidden
                    right-0
                    top-12
                    text-sm
                  "
        >
            <div class="flex flex-col cursor-pointer">
                <template v-if="!$page.props.user">
                    <MenuLink :href="route('login')" label="Войти"/>
                    <MenuLink :href="route('register')" label="Зарегистрироваться"/>
                </template>
                <template v-else>
                    <MenuLink :href="route('login')" label="Избранное"/>
                    <MenuLink :href="route('login')" label="Мои бронирования"/>
                    <hr/>
                    <MenuLink @click="logout" label="Выйти"/>
                </template>
                <!--                        {currentUser ? (-->
                <!--                        <>-->
                <!--                        <MenuItem-->
                <!--                            label="My trips"-->
                <!--                            onClick={()-->
                <!--                        => router.push('/trips')}-->
                <!--                        />-->
                <!--                        <MenuItem-->
                <!--                            label="My favorites"-->
                <!--                            onClick={()-->
                <!--                        => router.push('/favorites')}-->
                <!--                        />-->
                <!--                        <MenuItem-->
                <!--                            label="My reservations"-->
                <!--                            onClick={()-->
                <!--                        => router.push('/reservations')}-->
                <!--                        />-->
                <!--                        <MenuItem-->
                <!--                            label="My properties"-->
                <!--                            onClick={()-->
                <!--                        => router.push('/properties')}-->
                <!--                        />-->
                <!--                        <MenuItem-->
                <!--                            label="Airbnb your home"-->
                <!--                            onClick={rentModal.onOpen}-->
                <!--                        />-->
                <!--                        <hr/>-->
                <!--                        <MenuItem-->
                <!--                            label="Logout"-->
                <!--                            onClick={()-->
                <!--                        => signOut()}-->
                <!--                        />-->
                <!--                    </-->
                <!--                    >-->
                <!--                    ) : (-->
                <!--                    <>-->
                <!--                    <MenuItem-->
                <!--                        label="Login"-->
                <!--                        onClick={loginModal.onOpen}-->
                <!--                    />-->
                <!--                    <MenuItem-->
                <!--                        label="Sign up"-->
                <!--                        onClick={registerModal.onOpen}-->
                <!--                    />-->
            </div>
        </div>
    </div>
</template>

