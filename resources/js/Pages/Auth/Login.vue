<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ModalLayout from "@/Layouts/ModalLayout.vue";
import Heading from "@/Components/Heading.vue";
import Input from "@/Components/Input.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in"/>

    <ModalLayout actionLabel="Войти"
                 :handleSubmit="submit">
        <template #title>
            Вход
        </template>
        <template #body>
            <div className="flex flex-col gap-4">
                <Heading
                    title="С возвращением"
                    subtitle="Войти в свой аккаунт"
                />
                <Input
                    id="email"
                    v-model="form.email"
                    label="Email"
                    :error="form.errors.email"
                    required
                />
                <Input
                    id="password"
                    v-model="form.password"
                    label="Пароль"
                    :error="form.errors.password"
                    type="password"
                    required
                />
            </div>
        </template>
    </ModalLayout>
</template>
