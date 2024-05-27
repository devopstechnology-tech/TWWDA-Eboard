<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {useRouter} from 'vue-router';
import useAuthenticateRequest from '@/common/api/requests/useAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();
const handleUnexpectedError = useUnexpectedErrorHandler();
const router = useRouter();

const {handleSubmit, setErrors, setFieldError, setFieldValue} = useForm<{
    id_number: string;
    password: string;
    remember: boolean;
}>({
    initialValues: {
        id_number: '',
        password: '',
        remember: false,
    },
});

const onSubmit = handleSubmit(async (values) => {
    try {
        const authenticatedUser = await useAuthenticateRequest(values);
        authStore.setUser(authenticatedUser);
        const route = authStore.intendedRoute ?? authStore.mainRoute;
        authStore.setIntendedRoute(undefined);
        await router.push(route);
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);

            if (err.messages._) {
                setFieldError('id_number', err.messages._);
            }
        } else {
            setFieldError('id_number', 'Something went wrong.');
            handleUnexpectedError(err);
        }
    } finally {
        setFieldValue('password', '');
    }
});
</script>

<template>
    <main id="login">
        <h1>Welcome</h1>
        <form novalidate @submit="onSubmit">
            <FormInput
                label="Email"
                name="email"
                placeholder="email@example.com"
                type="email"
            />
            <FormInput
                label="Password"
                name="password"
                placeholder="Your password"
                type="password"
            />
            <button type="submit" class="login-button">Log in</button>
        </form>
        <p>or</p>
        <RouterLink to="" class="register-link">
            Create an Account
        </RouterLink>
    </main>
</template>
<style>
#login {

    @apply container h-full max-w-md;
    @apply flex flex-1 flex-col gap-8 items-center justify-center;
    @apply mx-auto p-3;

    h1 {
        @apply text-3xl;
    }

    form {
        @apply flex flex-col gap-4 self-stretch;
    }

    .login-button {
        @apply bg-red-600 text-light font-bold;
        @apply rounded-md px-20 mt-5;
        @apply p-4 px-4;
        @apply uppercase;
    }

    .register-link {
        @apply underline;
        @apply tracking-wide;

    }
}
</style>
