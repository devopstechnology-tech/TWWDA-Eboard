<script lang="ts" setup>
import {useMutation} from '@tanstack/vue-query';
import {useForm} from 'vee-validate';
import {useRouter} from 'vue-router';
import * as yup from 'yup';
import {useStaffLoginRequest} from '@/common/api/requests/staff/useStaffAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {DASHBOARD,
    FORGOT_PASSWORD,
    LOGIN,
} from '@/common/constants/staffRouteNames';
import ValidationError from '@/common/errors/ValidationError';
// import {AuthenticatedUser} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';
import {AuthenticateRequestPayload} from '@/common/types/types';

const authStore = useAuthStore();
const handleUnexpectedError = useUnexpectedErrorHandler();
const router = useRouter();
const schema = yup.object({
    email: yup.string().required('Email is a required field.'),
    password: yup.string().required(),
});
const {handleSubmit, setErrors, setFieldError} = useForm<{
    email: string;
    password: string;
    remember: boolean;
}>({
    validationSchema: schema,
    initialValues: {
        email: '',
        password: '',
        remember: false,
    },
});

const {
    mutate: login,isLoading} = useMutation((payload: AuthenticateRequestPayload) => useStaffLoginRequest(payload), {
    onSuccess: async () => {
        
        // authStore.setUser(data);
        if (authStore.intendedRoute) {
            await router.push(authStore.intendedRoute);
        } else {
            // const route = authStore.intendedRoute ?? authStore.mainRoute;
            authStore.setIntendedRoute(undefined);
            await router.push({name: DASHBOARD});
        }
    },
    onError: (error) => {
        if (error instanceof ValidationError) {
            // eslint-disable-next-line no-console
            setFieldError('email', error.messages._);
            setErrors(error.messages);
            if (error.messages._) {
                setFieldError('email', error.messages._);
            }
        } else {
            setFieldError('email', 'Something went wrong.');
            handleUnexpectedError(error);
        }
    },
});


const onSubmit = handleSubmit(async (values) => {
    login(values);
});
</script>

<template>
    <div class="card card-outline card-primary">
        <div class="card-header text-center h1 text-primary">
            <router-link :to="{name:LOGIN}" class="1"><b>Eboard</b>System</router-link>
        </div>
        <div class="card-body">
            <p class="login-box text-primary">Sign in to start your session</p>
            <form novalidate @submit="onSubmit">
                <div class="input-group mb-3">
                    <FormInput
                        direction="up"
                        label="Email **"
                        name="email"
                        class="w-full text-sm  tracking-wide"
                        placeholder="Enter your Email"
                        type="email"
                    />
                </div>

                <div class="input-group mb-3">
                    <FormInput
                        direction="up"
                        label="Password **"
                        name="password"
                        class="w-full text-sm tracking-wide"
                        placeholder="*****"
                        type="password"
                    />
                </div>
                <div class="row">
                    <div class="col-12">
                        <button  v-if="!isLoading" type="submit" class="btn btn-primary btn-block">Sign In</button>
                        <LoadingComponent v-else/>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mb-1 text-primary">
                <RouterLink :to="{name:FORGOT_PASSWORD}">I forgot my password</RouterLink>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
</template>
<style>
.btn-primary {
    color: #000000;
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: none;
    }
</style>
