<script lang="ts" setup>
import {useMutation} from '@tanstack/vue-query';
import {useForm} from 'vee-validate';
import {ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useAcceptInviteRequest} from '@/common/api/requests/modules/user/useUserRequest';
import {useChangePasswordRequest} from '@/common/api/requests/staff/useStaffAuthenticateRequest';
import useAuthenticateRequest from '@/common/api/requests/useAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {DASHBOARD, FORGOT_PASSWORD} from '@/common/constants/staffRouteNames';
import ValidationError from '@/common/errors/ValidationError';
import {AcceptInviteRequestPayload, AuthenticatedUser} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';
import {ChangePasswordPayload} from '@/common/types/types';

const authStore = useAuthStore();
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const router = useRouter();

const Token = route.query.token as string;
const errorMessage = ref('');
const jsonError = ref('');
const showError = ref(false);

const userschema = yup.object({
    otp: yup.string().required(),
    password: yup.string().required(),
    token: yup.string().required(),
    //agenda

});
const {handleSubmit, setErrors} = useForm<{
    otp: string;
    password: string;
    token: string;
}>({
    validationSchema: userschema,
    initialValues: {
        otp:'',
        password:'',
        token:Token,
    },
});

const {mutate: register, isLoading} = useMutation(
    (payload: ChangePasswordPayload) => useChangePasswordRequest(payload),
    {
        onSuccess: async () => {
            if (authStore.intendedRoute) {
                await router.push(authStore.intendedRoute);
            } else {
                authStore.setIntendedRoute(undefined);
                await router.push({name: DASHBOARD});
            }
        },
        onError: async (error) => {
            if (error.response && error.response.status === 403) {
                try {
                    const errorData = await error.response.json();
                    errorMessage.value = `Access Denied: ${errorData.errors}`;
                    showError.value = true;
                    setTimeout(() => {
                        router.push({name: FORGOT_PASSWORD});
                    }, 5000); // Wait 5 seconds before redirecting
                } catch (jsonrror) {
                    console.error('Error parsing JSON:', jsonrror);
                    jsonError.value = 'Error parsing the error message.';
                    showError.value = true;
                }
            } else if (error instanceof ValidationError) {
                setErrors(error.messages);
            } else {
                handleUnexpectedError(error);
            }
        },
    },
);


const onSubmit = handleSubmit(async (values) => {
    if (values.otp && typeof values.otp !== 'string') {
        values.otp = String(values.otp);
    }
    register(values);
});
</script>

<template>
    <div class="card card-outline card-primary register-box">
        <div class="card-header text-center h1 text-primary">
            <router-link to="" class="1"><b>Eboard</b>System</router-link>
            <div class="font-bold error-message text-danger">{{ errorMessage }}</div>
        </div>
        <div class="card-body">
            <p class="login-box-msg text-primary" v-if="!showError">
                Change Your Password as You Desire, don't share it
            </p>
            <p class="login-box-msg text-danger" v-if="showError && !jsonError">
                {{ errorMessage }}
            </p>
            <p class="login-box-msg text-danger" v-if="jsonError">
                {{ jsonError }}
            </p>
            <form novalidate @submit="onSubmit">
                <div class="row">
                    <FormInput
                        :labeled="true"
                        direction="up"
                        label="OTP"
                        name="otp"
                        class="w-full text-sm  tracking-wide col-md-12 mb-2"
                        placeholder="Enter your OTP"
                        type="number"
                    />
                    <FormInput
                        :labeled="true"
                        direction="up"
                        label="Password **"
                        name="password"
                        class="w-full text-sm tracking-wide col-md-12 mb-2"
                        placeholder="*****"
                        type="password"
                    />
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button  v-if="!isLoading" type="submit" class="btn btn-primary btn-block">Sign In</button>
                        <LoadingComponent v-else/>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</template>
<style>

</style>


