<script setup>
import ButtonComponent from "@/Components/ButtonComponent.vue";
import {OhVueIcon, addIcons} from "oh-vue-icons";
import { LaVk, FcGoogle } from "oh-vue-icons/icons";


addIcons(LaVk, FcGoogle);

const socialRedirect = (provider) => {
  window.location.href = route('social_redirect', {
    provider
  })
}
</script>

<template>
  <ButtonComponent :outline="true" label="С помощью вконтакте" @click="socialRedirect('vkontakte')">
    <template #icon>
      <OhVueIcon name="la-vk" scale="2" class="absolute left-4 top-1"/>
    </template>
  </ButtonComponent>
  <ButtonComponent :outline="true" label="С помощью google" @click="socialRedirect('google')">
    <template #icon>
      <OhVueIcon name="fc-google" scale="1.5" class="absolute left-5 top-2.5"/>
    </template>
  </ButtonComponent>
</template>
