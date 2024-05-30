<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {ref} from 'vue';
import {useRouter} from 'vue-router';
import * as yup from 'yup';
import {useForgotPasswordRequest} from '@/common/api/requests/staff/useStaffAuthenticateRequest';
// import useAuthenticateRequest from '@/common/api/requests/useAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {LOGIN} from '@/common/constants/staffRouteNames';
import ValidationError from '@/common/errors/ValidationError';
import router from '@/router';

const handleUnexpectedError = useUnexpectedErrorHandler();

const isSuccess = ref(false);

const schema = yup.object({
    email: yup.string().required('Email is a required field.'),
});
const {handleSubmit, setErrors, setFieldError} = useForm<{
    email: string;
}>({
    validationSchema: schema,
    initialValues: {
        email: '',
    },
});

const onSubmit = handleSubmit(async (values) => {
    try {
        await useForgotPasswordRequest(values); 
        isSuccess.value = true;  // Indicate success
        setTimeout(() => {
            // Close modal after 5 seconds and redirect to login
            router.push({name: LOGIN});
        }, 5000);
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
    }
});
</script>

<template>
    <div class="card-header text-center">
        <RouterLink :to="{name: LOGIN}" class="h1 text-primary"><b>Eboard</b>System</RouterLink>
    </div>
    <div class="card-body">
        <p class="login-box-msg text-primary" v-if="!isSuccess">
            You forgot your password? Here you can easily retrieve a new password.
        </p>
        <p class="login-box-msg text-primary" v-else>
            Please check your email for the reset link.
        </p>
        <form novalidate @submit="onSubmit" v-if="!isSuccess">
            <div class="input-group mb-3">
                <FormInput
                    direction="up"
                    label="Email **"
                    name="email"
                    class="w-full text-sm  tracking-wide"
                    placeholder="Enter your email"
                    type="email"
                />
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Request Change Password</button>
                </div>
            </div>
        </form>
        <p class="mt-3 mb-1 text-primary" v-if="!isSuccess">
            <RouterLink :to="{name: LOGIN}" class="text-black underline my-12 ">
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
