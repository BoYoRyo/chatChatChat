<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    account_id:'',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation' , 'account_id'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <!-- 名前 -->
            <div>
                <InputLabel for="name" value="名前" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <!-- メールアドレス -->
            <div class="mt-4">
                <InputLabel for="email" value="メールアドレス" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <!-- パスワード -->
            <div class="mt-4">
                <InputLabel for="password" value="パスワード" />
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <!-- 確認パスワード -->
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="確認パスワード" />
                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
            <!-- アカウントID -->
            <div class="mt-4">
                <InputLabel for="account_id" value="アカウントID" />
                <TextInput id="account_id" type="text" class="mt-1 block w-full" v-model="form.account_id" required  />
                <InputError class="mt-2" :message="form.errors.account_id" />
            </div>

            <!-- アイコン -->
            <!-- <div class="mt-4">
                <InputLabel for="icon" value="アイコン" />
                <input id="icon" type="file"  class="mt-1 block w-full"  required  />
                <InputError class="mt-2" :message="form.errors.icon" v-on:change="form.icon" />
            </div>   -->

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    登録済みの方はこちら
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    登録
                </PrimaryButton>
            </div>
        </form>

    </GuestLayout>
</template>
