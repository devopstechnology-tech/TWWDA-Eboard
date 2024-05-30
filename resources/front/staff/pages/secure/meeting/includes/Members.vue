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
    useGetBoardMembersRequest} from '@/common/api/requests/modules/member/useMemberRequest';
import {
    useCreateMembershipRequest,
    useGetMembershipsRequest,
    useUpdateMembershipRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
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
import {MembershipEditParams, MembershipRequestPayload} from '@/common/parsers/membershipParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';

//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const action = ref('create');
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const showCreate = ref(false);
const membershipsmodal = ref<HTMLDialogElement | null>(null);
const selectedMemberIds = ref<string[]>([]);
const allMembers = ref<Member[]>([]);

const {errorMessage} = useField('assignees');

const memberschema = yup.object({
    board_id: yup.mixed().required(),
    meeting_id: yup.mixed().required(),
    memberships: yup.array().of(yup.string()).required('Members selection is required.'),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    board_id: string;
    meeting_id: string;
    memberships: string[];

}>({
    validationSchema: memberschema,
    initialValues: {
        board_id: boardId,
        meeting_id: meetingId,
        memberships: [],
    },
});
const selectedMembers = () => {
    setFieldValue('memberships', selectedMemberIds.value);
};
const removeselectedMembers = () => {
    setFieldValue('memberships', selectedMemberIds.value);
};
const openEditMembershipsModal = (params: MembershipEditParams) => {
    console.log(params.memberships);//pick only members id, btu has use_id so ca n be used in backend
    const memberIds = params.memberships.map(membership => membership.member.id.toString());
    selectedMemberIds.value = memberIds; // Update the ref with the new array
    setFieldValue('memberships', selectedMemberIds.value);
    action.value = 'edit';
    showCreate.value = true;
    membershipsmodal.value?.showModal();
};


const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        setFieldValue('memberships', selectedMemberIds.value);
        const payload: MembershipRequestPayload = {
            board_id: values.board_id,
            memberships: values.memberships,
        };
        if (action.value === 'create') {
            await useCreateMembershipRequest(payload, meetingId, boardId);
        } else {
            await useUpdateMembershipRequest(payload, meetingId, boardId);
        }
        await fetchMemberships();
        reset();
        membershipsmodal.value?.close();
        // Dispatch a global custom event
        window.dispatchEvent(new CustomEvent('membershipsUpdated', {detail: {meetingId, boardId}}));
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
    setFieldValue('memberships', []);
};

const getMemberships = () => {
    return useQuery({
        queryKey: ['getMembershipsKey', boardId, meetingId],
        queryFn: async () => {
            const response = await useGetMembershipsRequest(meetingId, boardId, {paginate: 'false'});
            return response.data;
        },
    });
};

const Members = computed(() => {
    const resul:  SelectedResult[] = [];
    if (allMembers.value && allMembers.value?.length > 0) {
        allMembers.value.reduce((accumulator, currentMember) => {
            accumulator.push({
                id: currentMember.id,
                name: `${currentMember.user.full_name}`,
            });
            return accumulator;
        }, resul);
    }
    console.log('resul', resul);
    return resul;
});
const getMembers = async () => {
    const data = await useGetBoardMembersRequest(boardId, {paginate: 'false'});
    allMembers.value = data.data;
};
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Members'}));
    getMembers();
});
const {isLoading, data: Memberships, refetch: fetchMemberships} = getMemberships();

</script>
<template>
    <div class="card">
        <div class="card-header flex items-center">
            <h2 class="card-header-title h3">Board Meeting Members</h2>
            <div class="ml-auto flex items-center space-x-2">
                <button class="btn btn-secondary btn-sm"
                        @click.prevent="openEditMembershipsModal(
                            {
                                memberships: Memberships
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
                                <button class="btn btn-link btn-sm list-sort asc" data-sort="member-name">Name</button>
                            </th>
                            <th scope="col">
                                <button class="btn btn-link btn-sm list-sort" data-sort="board-role">Board Role</button>
                            </th>
                            <th scope="col" class="text-center">
                                <button class="btn btn-link btn-sm list-sort" data-sort="admin">Group Admin</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" v-if="Memberships">
                        <tr v-for="(membership, idx) in Memberships" :key="idx">
                            <td class="member-name" data-name="Felix Nyariki">
                                <div class="flex items-center space-x-3" v-if=" membership.user">
                                    <div class="avatar avatar-sm">
                                        <img
                                            class="far fa-user avatar-img rounded-full"
                                            role="img"
                                            data-uw-rm-alt="ALT"
                                        />
                                    </div>
                                    <h3 class="m-2">
                                        {{ membership.user.full_name }}
                                    </h3>
                                </div>
                            </td>

                            <td class="board-role">
                                {{ membership.member.position }}
                            </td>
                            <td class="admin text-center" data-admin="0">
                                <p class="my-0 leading-none p-2 mx-auto" v-if="membership.position === 'Owner'">
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
        <dialog id="membershipsmodal" class="modal" ref="membershipsmodal">
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
                                    :options="Members"
                                    :valueProp="'id'"
                                    :trackBy="'id'"
                                    :label="'name'"
                                    :class="['multiselect-container', { error: !!errorMessage }]"
                                    @select="selectedMembers()"
                                    @deselect="removeselectedMembers()"
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


