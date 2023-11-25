<script setup lang="ts">
import {OhVueIcon, addIcons} from 'oh-vue-icons'
import {HiSolidMenu, HiX} from 'oh-vue-icons/icons'
import {computed, ref} from 'vue'
import Avatar from '@/Components/Avatar.vue'
import MenuLink from '@/Components/MenuLink.vue'
import {router, usePage} from '@inertiajs/vue3'
import ModalLogout from "@/Components/Modals/ModalLogout.vue";
import useToasts from "@/hooks/useToasts";

addIcons(HiSolidMenu, HiX)

const isOpen = ref(false)
const setIsOpen = (value: Boolean) => {
    isOpen.value = value
}
const toggleOpen = () => {
    setIsOpen(!isOpen.value)
}

const {successToast} = useToasts()

const logout = () => {
    router.post(route('logout'))
    setShowLogoutDialog(false)
    successToast('Вы успешно вышли из аккаунта.')
}

const page = usePage()
const avatar = computed(() => {
    return page.props.user?.data?.avatar ?? null
})


const showLogoutDialog = ref(false)
const setShowLogoutDialog = (value) => {
    showLogoutDialog.value = value
}

const redirectToDashboard = () => {
    window.location.href = route('filament.admin.pages.dashboard')
}
</script>

<template>
    <div class="relative">
        <ModalLogout :is-open="showLogoutDialog" @onClose="setShowLogoutDialog(false)" @onLogout="logout"/>
        <div class="flex flex-row items-center gap-3">
            <div
                @click="toggleOpen"
                class="p-4 md:py-1 md:px-2 border-[1px] border-neutral-200 flex flex-row items-center gap-3 rounded-full cursor-pointer hover:shadow-md transition"
            >
                <OhVueIcon
                    name="hi-solid-menu"
                    v-if="!isOpen"
                />
                <OhVueIcon
                    name="hi-x"
                    v-else
                />
                <div class="hidden md:block">
                    <Avatar :src="avatar"/>
                </div>
            </div>
        </div>
        <div
            v-if="isOpen"
            class="absolute rounded-xl shadow-md w-[40vw] md:w-[22vw] bg-white overflow-hidden right-0 top-12 text-sm"
        >
            <div class="flex flex-col cursor-pointer">
                <template v-if="!$page.props.user">
                    <MenuLink
                        :href="route('login')"
                        label="Войти"
                    />
                    <MenuLink
                        :href="route('register')"
                        label="Зарегистрироваться"
                    />
                </template>
                <template v-else>
                    <MenuLink
                        :href="route('account.index')"
                        label="Аккаунт"
                    />
                    <hr/>
                    <MenuLink
                        v-if="$page.props.user.data.is_admin"
                        @click="redirectToDashboard"
                        label="Дашборд"
                    />
                    <MenuLink
                        @click="setShowLogoutDialog(true)"
                        label="Выйти"
                    />
                </template>
            </div>
        </div>
    </div>
</template>
