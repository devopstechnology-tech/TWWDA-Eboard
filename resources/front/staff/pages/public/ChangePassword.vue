<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {useRouter} from 'vue-router';
// import useAuthenticateRequest from '@/common/api/requests/useAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {LOGIN} from '@/common/constants/customerRouteNames';
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
        // const authenticatedUser = await useAuthenticateRequest(values);
        // authStore.setUser(authenticatedUser);
        // const route = authStore.intendedRoute ?? authStore.mainRoute;
        // authStore.setIntendedRoute(undefined);
        // await router.push(route);
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
    <section
        class="h-full bg-gradient-to-l from-blue-primary to-blue-veryDark
        flex justify-center  items-center flex-col">
        <div class="flex justify-center ">
            <div class="text-white">
                <div class="flex mx-4 flex-col  items-center text-center">
                    <h1
                        class="font-semibold text-left lg:text-6xl md:text-5xl text-4xl lg:mt-24 mt-6
                                text-white tracking-wide" style="line-height: 4rem">
                        Change Password
                    </h1>
                    <p class="lg:mt-12 lg:mx-12 mt-2 mx-4 w-full lg:text-lg sm:block leading-loose  lg:w-5/6">
                        Change your password in case you forgot it.
                    </p>
                </div>

            </div>
        </div>
        <div class="lg:w-6/12 w-full px-4  mt-12">
            <div class="font-thin text-sm flex flex-col items-center gap-6">
                <form novalidate @submit="onSubmit"
                      class="px-4 flex flex-col w-full rounded-xl justify-evenly
                      gap-3  lg:gap-4 mx-auto border border-gray-800 p-4">
                    <FormInput
                        direction="up"
                        label="OTP"
                        name="otp"
                        class="text-white w-full text-sm  tracking-wide"
                        placeholder="Enter OTP sent to phone"
                        type="number"
                    />
                    <FormInput
                        direction="up"
                        padding="p-1"
                        label="New Password"
                        name="password"
                        class="text-white w-full text-sm  tracking-wide"
                        placeholder="Enter your new password"
                        type="email"
                    />
                    <FormInput
                        direction="up"
                        padding="p-1"
                        label="Re-enter Password"
                        name="password"
                        class="text-white w-full text-sm  tracking-wide"
                        placeholder="Re Enter your new password"
                        type="email"
                    />

                    <button type="submit" class="login-button mb-1 w-full ml-1 pt-1 text-red-600 mt-6">
                        Change Password
                    </button>
                </form>

            </div>
            <RouterLink :to="{name:LOGIN}" class="text-white underline my-12 flex items-center justify-center ">
                Already has Account, Login
            </RouterLink>
        </div>
    </section>
</template>
<style>
.login-button {
    @apply bg-secondary text-black font-bold;
    @apply rounded-md h-12;
    @apply uppercase;
}
</style>
