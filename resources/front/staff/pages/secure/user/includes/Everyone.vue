<script lang="ts" setup>
import {useQuery} from '@tanstack/vue-query';
import {FieldArrayContext,useField, useFieldArray, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {
    useCreateUserRequest,
    useDeleteUserRequest,
    useGetUsersRequest,
    useUpdateUserRequest,
} from '@/common/api/requests/modules/user/useUserRequest';
import FormEmailsInput from '@/common/components/FormEmailsInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import RadioButton from '@/common/components/RadioButton.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formattedDateTime,loadAvatar,} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {AcceptInviteRequestPayload, User, UserRequestPayload} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';


const authStore = useAuthStore();

const router = useRouter();
const showCreate = ref(false);
const action = ref('create');
const UserModal = ref<HTMLDialogElement | null>(null);
const UsersModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();
// oneagnda
const createUserSchema = yup.object({
    email: yup.string().required('Email is required'),
    role: yup.string().required('Role is required'),
});
const {
    handleSubmit: handleSubmitCreate,
    setErrors,
    setFieldValue,
    values: createValues,
    errors: createErrors,
}  = useForm({
    validationSchema: createUserSchema,
    initialValues: {
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

const onSubmitCreate  = handleSubmitCreate(async (values, {resetForm}) => {
    console.log('ddd');
    try {
        if (action.value === 'create') {
            const payload: UserRequestPayload = {
                email: values.email,
                role: values.role,
            };
            await useCreateUserRequest(payload);
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
// Define the schema for editing a user
// const editUserSchema = yup.object({
//     first: yup.string().required('First name is required'),
//     last: yup.string().required('Last name is required'),
//     id_number: yup.string().required('ID number is required'),
//     email: yup.string().email('Invalid email format').required('Email is required'),
//     phone: yup.string().required('Phone number is required'),
//     password: yup.string().nullable(),
// });
// const {
//     handleSubmit: handleSubmitEdit,
//     setErrors: setEditErrors,
//     setFieldValue: setEditFieldValue,
//     values: editValues,
//     errors: editErrors,
// } = useForm<{
//     first: string;
//     last: string;
//     id_number: string;
//     email: string;
//     phone: string;
//     password: string | null;
// }>({
//     validationSchema: editUserSchema,
//     initialValues: {
//         first:'',
//         last:'',
//         id_number:'',
//         email:'',
//         phone:'',
//         password:'',
//     },
// });

// const openEditUserModal = (user:User) => {
//     selectedUser.value = user;
//     userId.value = user.id;
//     // Set field values here
//     setEditFieldValue('first', user.first);
//     setEditFieldValue('last', user.last);
//     setEditFieldValue('id_number', user.id_number);
//     setEditFieldValue('email', user?.email);
//     setEditFieldValue('phone', user.phone);
//     setEditFieldValue('password', user.password);
//     action.value = 'edit';
//     showCreate.value = true;
//     UsersModal.value?.showModal();
// };
const openUserProfile = (user:User) => {
    router.push({
        name: 'ProfileDetails',  // The name of the route to navigate to
        params: {
            userId: user.id,
            profileId: user.profile.id,
        },
    });
};
// const  onSubmitEdit = handleSubmitEdit (async (editValues, {resetForm}) => {
//     try {
//         console.log('ddd');
//         const payload: AcceptInviteRequestPayload = {
//             id: userId.value ? userId.value.toString() : null,
//             first: editValues.first,
//             last: editValues.last,
//             id_number: editValues.id_number,
//             email: editValues.email,
//             phone: editValues.phone,
//             password: editValues.password,
//             token: null,
//         };
//         console.log('payload',payload);
//         await useUpdateUserRequest(payload);

//         await fetchUsers();
//         UsersModal.value?.close();
//         resetEditForm();
//     } catch (err) {
//         if (err instanceof ValidationError) {
//             setEditErrors(err.messages);
//         } else {
//             handleUnexpectedError(err);
//         }
//     }
// });
const resetCreateForm = () => {
    setFieldValue('email', '');
    setFieldValue('role', '');
    showCreate.value = false;
    // Ensure other state resets if necessary
};
const resetEditForm = () => {
    setEditFieldValue('first', '');
    setEditFieldValue('last', '');
    setEditFieldValue('id_number', '');
    setEditFieldValue('email', '');
    setEditFieldValue('phone', '');
    setEditFieldValue('password', '');
    showCreate.value = false; // This might be better renamed or independently managed
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


</script>
<template>
    <div class="card-header flex items-center">
        <div class="flex items-center flex-1 w-full">
            <h2 class="card-header-title h3">
                Users
            </h2>
        </div>
        <div class="flex items-center space-x-2" v-if="authStore.hasRole(['Super Admn', 'Admin'])">
            <button type="button" @click.prevent="openCreateUserModal" class="btn  btn-sm btn-primary">
                <i class="far fa fa-plus mr-2"></i> <span class="">Add User</span>
            </button>
        </div>
    </div>
    <div class="card" v-for="(user, idx) in Users" :key="user.id">
        <div class="card-body flex" >
            <div class="avatar avatar-xl mr-5">
                <a href="" aria-label="Open Cynthia Muriithi User Profile">
                    <img
                        :src="loadAvatar(user.profile.avatar)"
                        class="avatar-img min-w-[82px] w-[82px] rounded-full"
                        role="img"
                        data-uw-rm-alt="ALT"
                    />
                </a>
            </div>
            <div class="mr-5">
                <h3 class="name mb-0 flex items-center text-bold text-primary mb-2">
                    <a href="" @click.prevent="openUserProfile(user)">
                        {{ user.full_name }}
                    </a>
                    <button  type="button" @click.prevent="openUserProfile(user)" title="" class="mx-2 btn btn-sm btn-icontext-green-500
                            hover:text-green-700 transition duration-150 ease-in-out btn-icon">
                        <i class="far fa-eye"></i>
                    </button>
                </h3>
                <div class="inline icons !items-start mb-2">
                    <div class="flex flex-wrap gap-1" v-if="user.membs">
                        <i class="fa fa-users mr-2"></i>
                        <span v-for="memmberin in user.membs" :key="memmberin.id" v-if="memmberin?.board">
                            <router-link :to="{ name: 'BoardDetails', params: { boardId: memmberin?.board.id } }"
                                         class="rounded-[9px] flex items-center justify-center
                                px-2 text-sm w-fit bg-gray-200 text-bold text-info">
                                {{ memmberin.board.name }}
                            </router-link>
                        </span>
                    </div>
                </div>
            </div>
            <div class="ml-auto flex flex-col justify-between items-end mb-2">
                <div class="social-icons flex text-bold text-danger" v-show="!idx > 0">
                    Account Role
                </div>
                <p class="whitespace-nowrap">{{ user.role }}</p>
            </div>
            <div class="ml-auto flex flex-col items-end mb-2">
                <div class="social-icons flex text-bold text-danger"  v-show="!idx > 0">
                    Board Role
                </div>
                <div class="social-icons flex text-bold text-danger"  v-show="user.role !== 'Super Admin'">
                    Potential Roles: Can be
                </div>
                <div class="lex text-bold text-primary"  v-show="user.role !== 'Super Admin'">
                    <ul class="">
                        <li class="whitespace-nowrap" v-for="rolename in user.rolenames" :key="rolename">
                            - {{ rolename }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ml-auto flex flex-col justify-between items-end mb-2">
                <div class="social-icons flex text-bold text-danger" v-show="!idx > 0">
                    Last Updated
                </div>
                <p class="whitespace-nowrap">
                    <span class="text-primary text-bold">{{ formattedDateTime(user.updated_at, null) }}</span>
                </p>
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

</template>


<style  scoped>
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
