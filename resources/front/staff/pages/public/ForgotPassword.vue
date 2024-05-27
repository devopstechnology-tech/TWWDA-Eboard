<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {useRouter} from 'vue-router';
// import useAuthenticateRequest from '@/common/api/requests/useAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {LOGIN} from '@/common/constants/staffRouteNames';
import ValidationError from '@/common/errors/ValidationError';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();
const handleUnexpectedError = useUnexpectedErrorHandler();
const router = useRouter();

const {handleSubmit, setErrors, setFieldError, setFieldValue} = useForm<{
    email: string;
    password: string;
    remember: boolean;
}>({
    initialValues: {
        email: '',
        password: '',
        remember: false,
    },
});

const onSubmit = handleSubmit(async (values) => {
    try {
        // const authenticatedUser = await useAuthenticateRequest(values);
        // authStore.setUser(authenticatedUser);
        const route = authStore.intendedRoute ?? authStore.mainRoute;
        authStore.setIntendedRoute(undefined);
        await router.push(route);
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);

            if (err.messages._) {
                setFieldError('email', err.messages._);
            }
        } else {
            setFieldError('email', 'Something went wrong.');
            handleUnexpectedError(err);
        }
    } finally {
        setFieldValue('password', '');
    }
});
</script>

<template>
    <div class="card-header text-center">
        <RouterLink :to="{name:LOGIN}" class="h1 text-primary"><b>Eboard</b>System</RouterLink>
    </div>
    <div class="card-body">
        <p class="login-box-msg text-primary">You forgot your password? Here you can easily retrieve a new password.</p>
        <form novalidate @submit="onSubmit">
            <div class="input-group mb-3">
                <FormInput
                    direction="up"
                    label="Email **"
                    name="name"
                    class="w-full text-sm  tracking-wide"
                    placeholder="Enter your email"
                    type="email"
                />
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <p class="mt-3 mb-1 text-primary">
            <RouterLink :to="{name:LOGIN}" class="text-black underline my-12 ">
                Already has Account, Login
            </RouterLink>
        </p>
    </div>
</template>
<style>
.login-button {
    @apply bg-secondary text-black font-bold;
    @apply rounded-md h-12;
    @apply uppercase;
}
</style>
