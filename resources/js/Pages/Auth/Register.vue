<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ModalLayout from "@/Layouts/ModalLayout.vue";
import Heading from "@/Components/Heading.vue";
import Input from  "@/Components/Input.vue"

const form = useForm({
    name: '',
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Register" />

    <ModalLayout actionLabel="Зарегистрироваться"
                 :handleSubmit="submit">
        <template #title>
            Регистрация
        </template>
        <template #body>
            <div className="flex flex-col gap-4">
                <Heading
                    title="Добро пожаловать"
                    subtitle="Создать аккаунт"
                />
                <Input
                    id="email"
                    v-model="form.email"
                    label="Email"
                    :error="form.errors.email"
                    required
                />
                <Input
                    id="name"
                    v-model="form.name"
                    label="Имя"
                    :error="form.errors.name"
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
