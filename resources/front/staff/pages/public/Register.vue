<script lang="ts" setup>
import {useMutation} from '@tanstack/vue-query';
import {useForm} from 'vee-validate';
import {ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useAcceptInviteRequest} from '@/common/api/requests/modules/user/useUserRequest';
import useAuthenticateRequest from '@/common/api/requests/useAuthenticateRequest';
import FormInput from '@/common/components/FormInput.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {DASHBOARD} from '@/common/constants/staffRouteNames';
import ValidationError from '@/common/errors/ValidationError';
import {AcceptInviteRequestPayload, AuthenticatedUser} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const router = useRouter();

const Token = route.query.token as string;
const errorMessage = ref('');

const userschema = yup.object({
    first: yup.string().required(),
    last: yup.string().required(),
    id_number: yup.string().required(),
    // email: yup.string().required(),
    phone: yup.string().required(),
    password: yup.string().required(),
    token: yup.string().required(),
    //agenda

});
const {handleSubmit, setErrors, setFieldError, setFieldValue} = useForm<{
    first: string;
    last: string;
    id_number: string;
    // email: string;
    phone: string;
    password: string;
    token: string;
}>({
    validationSchema: userschema,
    initialValues: {
        first:'',
        last:'',
        id_number:'',
        // email:'',
        phone:'',
        password:'',
        token:Token,
    },
});

const {mutate: register, isLoading} = useMutation(
    (payload: AcceptInviteRequestPayload) => useAcceptInviteRequest(payload),
    {
        onSuccess: async (data: AuthenticatedUser) => {
            authStore.setUser(data);
            if (authStore.intendedRoute) {
                await router.push(authStore.intendedRoute);
            } else {
                authStore.setIntendedRoute(undefined);
                await router.push({name: DASHBOARD});
            }
        },
        onError: (error) => {
            errorMessage.value = 'TOKEN EXPIRED, request Admin To Invite You Again';
            if (error instanceof ValidationError) {
                setErrors(error.messages);

            } else {
                handleUnexpectedError(error);
            }

        },
    });

const onSubmit = handleSubmit(async (values) => {
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
            <p class="login-box-msg text-primary">Complete You r Registration to start your session</p>
            <form novalidate @submit="onSubmit">
                <div class="row">
                    <FormInput
                        :labeled="true"
                        direction="up"
                        label="Your First Name"
                        name="first"
                        class="w-full text-sm  tracking-wide col-md-6"
                        placeholder="Enter your First Name"
                        type="text"
                    />
                    <FormInput
                        :labeled="true"
                        direction="up"
                        label="Your Last Name"
                        name="last"
                        class="w-full text-sm  tracking-wide col-md-6 mb-2"
                        placeholder="Enter your Last Name"
                        type="text"
                    />
                    <FormInput
                        :labeled="true"
                        direction="up"
                        label="ID Number"
                        name="id_number"
                        class="w-full text-sm  tracking-wide col-md-6 mb-2"
                        placeholder="Enter your ID Number"
                        type="number"
                    />
                    <FormInput
                        :labeled="true"
                        direction="up"
                        label="Phone"
                        name="phone"
                        class="w-full text-sm  tracking-wide col-md-6 mb-2"
                        placeholder="Enter your Phone"
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


