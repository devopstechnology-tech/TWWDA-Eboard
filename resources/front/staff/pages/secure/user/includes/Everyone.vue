<script lang="ts" setup>
import {useQuery} from '@tanstack/vue-query';
import {FieldArrayContext, useField, useFieldArray, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {
    useCreateUserRequest,
    useDeleteUserRequest,
    useGetUsersRequest,
    useUpdateUserRequest,
    useUpdateUserRoleRequest,
} from '@/common/api/requests/modules/user/useUserRequest';
import {useGetRolesRequest} from '@/common/api/requests/roleperm/useRolesRequest';
import FormEmailsInput from '@/common/components/FormEmailsInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import RadioButton from '@/common/components/RadioButton.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formattedDateTime, loadAvatar} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Role} from '@/common/parsers/roleParser';
import {AcceptInviteRequestPayload, User, UserRequestPayload} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';
import UserRole from '@/staff/pages/secure/user/includes/UserRole.vue';

// v-if="authStore.hasPermission(['view meeting'])"
const authStore = useAuthStore();
const route = useRoute();

const router = useRouter();
const showCreate = ref(false);
const action = ref('create');
const UserModal = ref<HTMLDialogElement | null>(null);
const UsersModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

// oneagnda
const createUserSchema = yup.object({
    id: yup.string().nullable(),
    email: yup.string().required('Email is required'),
    role: yup.string().required('Role is required'),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
    errors,
} = useForm<{
    id: string;
    role: string;
    email: string;

}>({
    validationSchema: createUserSchema,
    initialValues: {
        id: '',
        email: '',
        role: '',
    },
});

const openCreateUserModal = () => {
    resetCreateForm();
    action.value = 'create';
    showCreate.value = true;
    UserModal.value?.showModal();
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        const payload: UserRequestPayload = {
            id: values.id,
            email: values.email,
            role: values.role,
        };
        if (action.value === 'create') {
            await useCreateUserRequest(payload);
        } else if (action.value === 'role') {
            await useUpdateUserRoleRequest(payload, payload.id);
        }
        await fetchUsers();
        resetCreateForm();
        UserModal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});

const openUserProfile = (user: User) => {
    router.push({
        name: 'ProfileDetails',  // The name of the route to navigate to
        params: {
            userId: user.id,
            profileId: user.profile.id,
        },
    });
};

const resetCreateForm = () => {
    setFieldValue('id', '');
    setFieldValue('email', '');
    setFieldValue('role', '');
    showCreate.value = false;
};

const customroles = [
    {name: 'Member', value: 'default'},
    {name: 'Admin', value: 'admin'},
    {name: 'Observer', value: 'observer'},
];

const Customroles = computed(() => {
    return customroles;
});

onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Users'}));
});
const getUsers = () => {
    return useQuery({
        queryKey: ['getUsersKey'],
        queryFn: async () => {
            const response = await useGetUsersRequest({paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading, data: Users, refetch: fetchUsers} = getUsers();

const handleRoleUpdated = (event: { userId: string; userEmail: string; role: string }) => {
    resetCreateForm();
    action.value = 'role';
    setFieldValue('id', event.userId);
    setFieldValue('role', event.role);
    setFieldValue('email', event.userEmail);
    onSubmit();
};

// Fetch roles once and pass to child components
const allRoles = ref<Role[]>([]);
const getRoles = async () => {
    const data = await useGetRolesRequest({paginate: 'false'});
    allRoles.value = data.data;
};
onMounted(async () => {
    await getRoles();
});
const onDeleteUser = async (id: string) => {
    await useDeleteUserRequest(id);
    await fetchUsers();
};

window.addEventListener('fetchUsersData', () => {
    fetchUsers();
});
</script>

<template>
    <div class="container-fluid" v-if="authStore.hasPermission(['view users'])">
        <div class="card-header flex items-center">
            <div class="flex items-center flex-1 w-full">
                <h2 class="card-header-title h3">
                    Users
                </h2>
            </div>
            <div class="flex items-center space-x-2"  v-if="authStore.hasPermission(['create user'])">
                <button type="button" @click.prevent="openCreateUserModal" class="btn  btn-sm btn-primary">
                    <i class="far fa fa-plus mr-2"></i> <span class="">Add User</span>
                </button>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3" v-for="(user, idx) in Users" :key="user.id">
                    <div class="card card-outline card-primary h-100">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <!-- Image and User Info Column -->
                                <div class="avatar avatar-md mb-3">
                                    <img
                                        :src="loadAvatar(user.profile.avatar)"
                                        class="profile-user-img img-fluid img-circle"
                                        role="img"
                                        data-uw-rm-alt="ALT"
                                    />
                                </div>
                                <h3 class="profile-username text-center text-primary">
                                    <a v-if="authStore.hasPermission(['view user profile'])" 
                                       href="" @click.prevent="openUserProfile(user)">
                                        {{ user.full_name }}
                                    </a>
                                    <button v-if="authStore.hasPermission(['view user profile'])"
                                            type="button" @click.prevent="openUserProfile(user)" 
                                            title="" class="mx-2 btn btn-sm btn-primary">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <button v-if="authStore.hasPermission(['delete user'])" 
                                            type="button" @click.prevent="onDeleteUser(user.id)" 
                                            title="" class="mx-2 btn btn-sm btn-primary">
                                        <i class="fa fa-trash mr-1"></i>
                                    </button>
                                </h3>
                                <p class="text-muted text-center text-bold">{{ user.role }}</p>
                            </div>
                            <!-- Action Column -->
                            <div class="mt-3" v-if="authStore.hasPermission(['assign user permision'])">
                                <div class="text-bold text-danger text-center mb-1" >
                                    Roles
                                </div>
                                <div class="text-center">
                                    <UserRole
                                        :user="user"
                                        :roles="allRoles"
                                        :disableRemoteRole="0"
                                        @role-updated="handleRoleUpdated"
                                    />
                                </div>
                            </div>
                            <div class="mt-3" v-else>
                                <div class="text-bold text-danger text-center mb-1" >
                                    Roles
                                </div>
                                <div class="text-center" >
                                    <!-- <i :class="'mr-2 fa ' + user.position.icon" class="mr-2"></i>  -->
                                    {{ user.roles[0]?.name }}
                                </div>
                            </div>
                            <!-- Last Updated Column -->
                            <div class="mt-3">
                                <div class="text-bold text-danger text-center mb-1">
                                    Last Updated
                                </div>
                                <p class="text-center text-primary text-small">
                                    {{ formattedDateTime(user.updated_at, null) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center col-md-6">
            <dialog id="usermodal" class="modal" ref="UserModal">
                <form method="dialog" class="modal-box rounded-xl">
                    <h3 class="font-bold text-lg justify-center flex">
                        {{'Add User'}}
                    </h3>
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    <div class="w-full mt-6 p-2">
                        <div class="font-thin text-sm flex flex-col items-center gap-6">
                            <form novalidate @submit.prevent="onSubmitCreate"
                                  class="w-full rounded-xl mx-auto p-1 custom-modal">
                                <FormInput
                                    :labeled="true"
                                    label="Email"
                                    name="email"
                                    class="w-full text-sm tracking-wide"
                                    placeholder="Enter User Email"
                                    type="email" />
                                <RadioButton
                                    :title="'Roles'"
                                    name="role"
                                    :options="Customroles" />
                                <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                    {{'Add User'}}
                                </button>
                            </form>
                        </div>
                    </div>
                </form>
            </dialog>
        </div>
        <div class="flex justify-center col-md-6">
            <dialog id="usersmodal" class="modal" ref="UsersModal">
                <div class="card card-outline card-primary register-box">
                    <form method="dialog" class="modal-box rounded-xl">
                        <h3 class="font-bold text-lg justify-center flex">
                            {{'Edit User'}}
                        </h3>
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        <div class="card-body">
                            <form novalidate @submit="onSubmitEdit">
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
                                        label="Email"
                                        name="email"
                                        class="w-full text-sm tracking-wide col-md-6 mb-2"
                                        placeholder="youe Email"
                                        type="email"
                                    />
                                    <FormInput
                                        :labeled="true"
                                        direction="up"
                                        label="Password **"
                                        name="password"
                                        class="w-full text-sm tracking-wide col-md-6 mb-2"
                                        placeholder="*****"
                                        type="password"
                                    />
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button  v-if="!isLoading" type="submit" class="btn btn-primary
                                btn-block">Sign In</button>
                                        <LoadingComponent v-else/>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
            </dialog>
        </div>
    </div>
    <div class="container-fluid" v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div> 
   
</template>

<style scoped>
.tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    padding: 5px 0;
}

.tag {
    background-color: #e1e1e1;
    border-radius: 5px;
    padding: 5px 10px;
    margin-right: 5px;
    display: flex;
    align-items: center;
}

.tag button {
    background: none;
    border: none;
    color: red;
    cursor: pointer;
    margin-left: 5px;
}

input {
    flex-grow: 1;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

</style>
