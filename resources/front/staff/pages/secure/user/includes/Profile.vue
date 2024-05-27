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
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formattedDateTime,loadDefaultUserIcon} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';


const showCreate = ref(false);
const action = ref('create');
const profileId = ref<string | null>(null);
const selectedUser = ref<User | null>(null);
const UserModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();


// oneagnda
const userschema = yup.object({
    name: yup.string().required(),
    emails: yup.array().of(yup.string()).required(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    name: string;
    emails: string[],

}>({
    validationSchema: userschema,
    initialValues: {
        emails: [],
        name: '',
    },
});

const openCreateUserModal = () => {
    action.value = 'create';
    showCreate.value = true;
    UserModal.value?.showModal();
};
const openEditUserModal = (user:User) => {
    selectedUser.value = user;
    profileId.value = user.id;
    // Set field values here
    setFieldValue('title', user.title);
    setFieldValue('duedate', user.duedate);
    setFieldValue('description', user.description);
    setFieldValue('status', user.status);
    setFieldValue('meeting_id', user.meeting_id);
    // if (user.userassignees){
    //     const userassigneeIds = user.userassignees.map(userassignee => userassignee.id);
    //     selectedMembershipIds.value = userassigneeIds;
    //     setFieldValue('userassignees', userassigneeIds);
    // } else {
    //     setFieldValue('userassignees', []);
    // }
    // schedules
    action.value = 'edit';
    showCreate.value = true;
    UserModal.value?.showModal();
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        setFieldValue('userassignees', selectedMembershipIds.value);
        const payload: UserRequestPayload = {
            title: values.title,
            duedate: values.duedate,
            description: values.description,
            status: values.status,
            meeting_id: values.meeting_id,
            user_id: null,
            userassignees: values.userassignees,
        };
        if (action.value === 'create') {
            await useCreateMeetingUserRequest(payload, meetingId, boardId);
        } else {
            const user_id = profileId.value ? profileId.value.toString() : null;
            payload.user_id = user_id,
            await useUpdateMeetingUserRequest(payload, meetingId, boardId);
        }
        await fetchMeetingUsers();
        reset();
        UserModal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});

const reset = () => {
    action.value = 'create';
    showCreate.value = false;
    profileId.value =null;
    selectedMembershipIds.value = [];
    setFieldValue('title', '');
    setFieldValue('duedate', '');
    setFieldValue('description', '');
    setFieldValue('userassignees', []);
};



onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Users'}));
});
const getMeetingUsers = () => {
    return useQuery({
        queryKey: ['getUsersKey'],
        queryFn: async () => {
            const response = await useGetUsersRequest({paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading, data: Users, refetch: fetchMeetingUsers} = getMeetingUsers();

interface FormState {
    emails: string[];
}

// const {handleSubmit, resetForm} = useForm<FormState>({
//     initialValues: {
//         emails: [],
//     },
// });

// const {fields: emailFields, remove, append} = useFieldArray({
//     name: 'emails',
// });

// const addEmail = (newEmail: string) => {
//     append(newEmail);
// };

// const onSubmit = handleSubmit(values => {
//     console.log(values.emails);
//     // Post these values to Laravel backend
// });
</script>
<template>
    <div class="card-header flex items-center">
        <div class="flex items-center flex-1 w-full">
            <h2 class="card-header-title h3">

            </h2>
        </div>
        <div class="flex items-center space-x-2">
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
                        :src="loadDefaultUserIcon('default_user.svg')"
                        alt="Cynthia Muriithi profile image"
                        class="avatar-img min-w-[82px] w-[82px] rounded-full"
                        data-uw-rm-alt-original="Cynthia Muriithi profile image"
                        role="img"
                        data-uw-rm-alt="ALT"
                    />
                </a>
            </div>
            <div class="mr-5">
                <h3 class="name mb-0 flex items-center text-bold text-primary">
                    <a href="" >
                        {{ user.full_name }}
                    </a>
                    <a href="" title="" class="mx-2 text-muted btn btn-sm btn-icon"
                       data-bs-original-title="Edit user profile" aria-label="Edit user profile">
                        <i class="far fa-edit"></i>
                    </a>
                </h3>
                <dl class="inline icons !items-start mb-0">
                    <dd class="flex flex-wrap gap-1">
                        <i class="fa fa-users mr-2"></i>
                        <span v-for="memmberin in user.membs" :key="memmberin.id">
                            <router-link :to="{ name: 'BoardDetails', params: { id: memmberin.board.id } }"
                                         class="rounded-[9px] flex items-center justify-center
                                px-2 text-sm w-fit bg-gray-200 text-bold text-info">
                                {{ memmberin.board.name }}
                            </router-link>
                        </span>
                    </dd>
                </dl>
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
                    <span class="text-black">Last Activity:</span>
                    <span class="text-primary text-bold">{{ formattedDateTime(user.updated_at, null) }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="usersmodal" class="modal" ref="UserModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{'Add Users'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1 custom-modal">
                            <div class="form-group">
                                <label>Emails:</label>
                                <div class="email-tags-input">
                                    <div class="tags">
                                        <!-- {{ emails }}
                                        <span v-for="(email, index) in emails" :key="index" class="tag">
                                            {{ email }}
                                            <button @click="removeEmail(index)">x</button>
                                        </span> -->
                                    </div>
                                    <FormInput
                                        label="Name"
                                        name="name"
                                        class="w-full text-sm tracking-wide"
                                        placeholder="Enter Meeting Agenda" t
                                        type="text" />
                                    <FormEmailsInput
                                        label="email"
                                        name="title"
                                        class="w-full text-sm tracking-wide"
                                        placeholder="Enter Users Email and press enter" t
                                        type="email" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{'Add Users'}}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
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
