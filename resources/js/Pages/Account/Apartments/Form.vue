<script setup>
import Input from "@/Components/Input.vue";
import {useForm} from "@inertiajs/vue3";
import TextareaInput from "@/Components/Inputs/TextareaInput.vue";
import FileInput from "@/Components/Inputs/FileInput.vue";
import ButtonComponent from "@/Components/ButtonComponent.vue";
import { router } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    description: '',
    media: []
})

const submit = () => {
    router.post(route('account.apartments.store'), form)
}
</script>

<template>
<div class="mt-10 flex flex-col gap-4">
    <Input
        id="title"
        v-model="form.title"
        label="Название"
        :error="form.errors.title"
    />
    <TextareaInput id="description"
               v-model="form.description"
               label="Описание"
               :error="form.errors.description"/>
    <FileInput  id="media"
                v-model="form.media"
                :error="form.errors.media"/>

    <div class="flex">
        <ButtonComponent class="max-w-[14rem]" label="Сохранить" @click="submit"/>
    </div>
</div>
</template>
