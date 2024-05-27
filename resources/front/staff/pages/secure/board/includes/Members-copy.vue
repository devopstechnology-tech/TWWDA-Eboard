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
const boardId = route.params.id as string;
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-widget">
                <div class="card-header">
                    <h1 class="h2 mb-2 lg:mb-0">Meeting Participants</h1>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        <button type="button" @click.prevent="openEditMembersModal(
                            {
                                members: Members
                            })" class="btn btn-tool">
                            <i class="far fa fa-plus mr-2 "></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="products-list product-list-in-card pl-2 pr-2"  v-if="Members">
                        <li class="item" v-for="member in Members" :key="member?.id">
                            <div class="product-info" v-if=" member.user">
                                <div class="product-title">{{ member.user.full_name }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
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
</style>

