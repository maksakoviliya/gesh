<script setup>
import Container from "@/Components/Container.vue";
import Logo from "@/Components/Logo.vue";
import Search from "@/Components/Search.vue";
import UserMenu from "@/Components/UserMenu.vue";
</script>

<template>
    <div class="fixed w-full bg-white z-10 shadow-sm">
        <div class="py-4 border-b-[1px]">
            <Container>
                <div class="
            flex
            flex-row
            items-center
            justify-between
            gap-3
            md:gap-0
          "
                >
                    <Logo/>
                    <Search/>
                    <UserMenu/>
                </div>
            </Container>
        </div>
    </div>
</template>
