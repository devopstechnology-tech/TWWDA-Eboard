<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {
    useCreateMemberRequest,
    useGetBoardMembersRequest,
    useUpdateMemberRequest} from '@/common/api/requests/modules/member/useMemberRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formattedDate,loadImage,test,truncateDescription} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Member, MemberEditParams,MemberRequestPayload,SelectedResult} from '@/common/parsers/memberParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';


//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const action = ref('create');
const boardId = route.params.boardId as string;
const showCreate = ref(false);
const membersmodal = ref<HTMLDialogElement | null>(null);
const selectedMemberIds = ref<string[]>([]);
const allUsers = ref<User[]>([]);

const {errorMessage} = useField('assignees');

const memberschema = yup.object({
    board_id: yup.mixed().required(),
    members: yup.array().of(yup.string()).required('Members selection is required.'),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    board_id: string;
    members: string[];

}>({
    validationSchema: memberschema,
    initialValues: {
        board_id: boardId,
        members: [],
    },
});
const selectedUsers = () => {
    setFieldValue('members', selectedMemberIds.value);
};
const removeselectedUsers = () => {
    setFieldValue('members', selectedMemberIds.value);
};
const openEditMembersModal = (params: MemberEditParams) => {
    const memberIds = params.members.map(member => member.user.id.toString());
    selectedMemberIds.value = memberIds; // Update the ref with the new array
    setFieldValue('members', selectedMemberIds.value);
    action.value = 'edit';
    showCreate.value = true;
    membersmodal.value?.showModal();
};



const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        setFieldValue('members', selectedMemberIds.value);
        const payload: MemberRequestPayload = {
            board_id: values.board_id,
            members: values.members,
        };
        if (action.value === 'create') {
            await useCreateMemberRequest(payload, boardId);
        } else {
            await useUpdateMemberRequest(payload, boardId);
        }
        await fetchBoardMembers();
        reset();
        membersmodal.value?.close();
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
    selectedMemberIds.value = [];
    setFieldValue('members', []);
};

const getBoardMembers = () => {
    return useQuery({
        queryKey: ['getBoardMembersKey', boardId],
        queryFn: async () => {
            const response = await useGetBoardMembersRequest(boardId, {paginate: 'false'});
            return response.data;
        },
    });
};


const Users = computed(() => {
    const resul:  SelectedResult[] = [];
    if (allUsers.value && allUsers.value?.length > 0) {
        allUsers.value.reduce((accumulator, currentUser) => {
            accumulator.push({
                id: currentUser.id,
                name: `${currentUser.full_name}`,
            });
            return accumulator;
        }, resul);
    }
    return resul;
});
const getUsers = async () => {
    const data = await useGetStaffsRequest({paginate: 'false'});
    allUsers.value = data.data;
};
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Members'}));
    getUsers();
});
const {isLoading, data: Members, refetch: fetchBoardMembers} = getBoardMembers();

</script>
<template>
    <div class="card">
        <div class="card-header flex items-center">
            <h2 class="card-header-title h3">Board Members</h2>
            <div class="ml-auto flex items-center space-x-2">
                <button class="btn btn-secondary btn-sm"
                        @click.prevent="openEditMembersModal(
                            {
                                members: Members
                            })">
                    Update Members
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <div id="member-list">
                <table class="table table-striped card-table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <button class="btn btn-link btn-sm list-sort asc" data-sort="user-name">Name</button>
                            </th>
                            <th scope="col">
                                <button class="btn btn-link btn-sm list-sort" data-sort="board-role">Board Role</button>
                            </th>
                            <th scope="col" class="text-center">
                                <button class="btn btn-link btn-sm list-sort" data-sort="admin">Group Admin</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" v-if="Members">
                        <tr v-for="(member, idx) in Members" :key="idx">
                            <td class="user-name" data-name="Felix Nyariki">
                                <div class="flex items-center space-x-3" v-if=" member.user">
                                    <div class="avatar avatar-sm">
                                        <img
                                            class="far fa-user avatar-img rounded-full"
                                            role="img"
                                            data-uw-rm-alt="ALT"
                                        />
                                    </div>
                                    <h3 class="m-2">
                                        {{ member.user.full_name }}
                                    </h3>
                                </div>
                            </td>

                            <td class="board-role">
                                {{ member.position }}
                            </td>
                            <td class="admin text-center" data-admin="0">
                                <p class="my-0 leading-none p-2 mx-auto" v-if="member.position === 'Owner'">
                                    Group Owner
                                </p>
                                <p class="my-0 leading-none p-2 mx-auto" v-else>
                                    <i class="fa fa-check"></i>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex justify-center col-md-6">
        <dialog id="membersmodal" class="modal" ref="membersmodal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{'Add Members'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1 custom-modal">
                            <div :class="['multiselect-container', { error: !!errorMessage }]">
                                <Multiselect
                                    id="members"
                                    v-model="selectedMemberIds"
                                    mode="tags"
                                    placeholder="Choose your stack"
                                    :close-on-select="false"
                                    :filter-results="false"
                                    :min-chars="1"
                                    :resolve-on-load="false"
                                    :delay="0"
                                    :searchable="true"
                                    :options="Users"
                                    :valueProp="'id'"
                                    :trackBy="'id'"
                                    :label="'name'"
                                    :class="['multiselect-container', { error: !!errorMessage }]"
                                    @select="selectedUsers()"
                                    @deselect="removeselectedUsers()"
                                />
                                <div v-if="errorMessage"  class="message">{{ errorMessage }}</div>
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{'Add Members'}}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</template>
<style scoped>

.btn-info {
  background-color: #17a2b8;
  color: #fff;
}
th button.list-sort {
    background-color: #f9fbfd;
    color: #4b6c92;
    font-size: .8125rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}
.avatar-sm {
    font-size: .8333333333rem;
    height: 2.5rem;
    width: 2.5rem;
}
.avatar {
    display: inline-block;
    font-size: 1rem;
    height: 3rem;
    position: relative;
    width: 3rem;
}
.rounded-full {
    border-radius: 9999px;
}
.avatar-img {
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    width: 100%;
}
img {
    display: block;
    max-width: 100%;
}
img, svg {
    vertical-align: middle;
}
</style>

