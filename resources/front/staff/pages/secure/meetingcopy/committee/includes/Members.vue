<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {useField, useForm} from 'vee-validate';
import {computed,defineEmits,inject,onMounted,ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {
    useGetBoardMembersRequest} from '@/common/api/requests/modules/member/useMemberRequest';
import {useGetMeetingPositionsRequest} from '@/common/api/requests/modules/member/usePositionRequest';
import {
    useCreateMembershipRequest,
    useGetMembershipsRequest,
    useUpdateMemberShipPositionRequest,
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
import {formattedDate,formattedDateTime,loadImage,test,truncateDescription} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Member, MemberEditParams,MemberRequestPayload,SelectedResult} from '@/common/parsers/memberParser';
import {MembershipEditParams, MemberShipPositionRequestPayload, MembershipRequestPayload} from '@/common/parsers/membershipParser';
import {Position} from '@/common/parsers/positionParser';
import {User} from '@/common/parsers/userParser';
import {Meta} from '@/common/types/types';
import MemberShipPosition from '@/staff/pages/secure/meeting/includes/MemberShipPosition.vue';
import Multiselect from '@@/@vueform/multiselect';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();
//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const router = useRouter();
const action = ref('create');
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const showCreate = ref(false);
const membershipsmodal = ref<HTMLDialogElement | null>(null);
const selectedMemberIds = ref<string[]>([]);
const allMembers = ref<Member[]>([]);

const emit = defineEmits(['memberships-updated']);
const {errorMessage} = useField('assignees');

const memberschema = yup.object({
    id: yup.string().nullable(),
    position_id: yup.string().nullable(),
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
    id: string;
    position_id: string;
    memberships: string[];

}>({
    validationSchema: memberschema,
    initialValues: {
        board_id: boardId,
        meeting_id: meetingId,
        id: '',
        position_id: '',
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
            await useCreateMembershipRequest(payload, meetingId, scheduleId);
        } else if(action.value === 'edit') {
            await useUpdateMembershipRequest(payload, meetingId, scheduleId);
        } else if(action.value === 'position') {
            const payload: MemberShipPositionRequestPayload = {
                id: values.id,
                position_id: values.position_id,
            };
            await useUpdateMemberShipPositionRequest(payload, meetingId, scheduleId);
        }
        await fetchMemberships();
        emit('memberships-updated');
        reset();
        membershipsmodal.value?.close();
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
    setFieldValue('id', '');
    setFieldValue('position_id', '');
};

const getMemberships = () => {
    return useQuery({
        queryKey: ['getMembershipsKey', meetingId, scheduleId],
        queryFn: async () => {
            const response = await useGetMembershipsRequest(meetingId, scheduleId, {paginate: 'false'});
            console.log('response.data', response.data);
            return response.data;
        },
    });
};

const {isLoading, data: Memberships, refetch: fetchMemberships} = getMemberships();
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
    // window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Members'}));
    getMembers();
});


// Fetch positions once and pass to child components
const allPositions = ref<Position[]>([]);
const getPositions = async () => {
    const data = await useGetMeetingPositionsRequest({paginate: 'false'});
    allPositions.value = data.data;
};
onMounted(async () => {
    await getPositions();
});
const handlePositionUpdated = (event: { membershipId: string; positionId: string }) => {
    reset();
    action.value = 'position';
    setFieldValue('id', event.membershipId);
    setFieldValue('position_id', event.positionId);
    onSubmit();
};
const openUserProfile = (user: User) => {
    router.push({
        name: 'ProfileDetails',  // The name of the route to navigate to
        params: {
            userId: user.id,
            profileId: user.profile.id,
        },
    });
};
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
        <div class="container-fluid">
            <div class="row" v-if="Memberships">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3" v-for="(membership, idx) in Memberships" :key="idx">
                    <div class="card card-outline card-primary h-100">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <!-- Image and User Info Column -->
                                <!-- <div class="avatar avatar-md mb-3">
                                    <a href="" >
                                        <img
                                            class="profile-user-img img-fluid img-circle"
                                            :src="loadAvatar(member.user.profile.avatar)"
                                            role="img"
                                            data-uw-rm-alt="ALT"
                                        />
                                    </a>
                                </div> -->
                                <h3 class="profile-username text-center text-primary">
                                    <a href="" @click.prevent="openUserProfile(membership.user)">
                                        {{ membership.user.full_name }}
                                    </a>
                                    <button type="button" @click.prevent="openUserProfile(membership.user)"
                                            title="" class="mx-2 btn btn-sm btn-primary">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <!-- <button v-show="member.user.role !== 'Super Admin'" 
                                            type="button" @click.prevent="onDeleteMember(member.id)"
                                            title="" class="mx-2 btn btn-sm btn-primary">
                                        <i class="fa fa-trash mr-1"></i>
                                    </button> -->
                                </h3>
                                <p class="text-muted text-center text-bold">{{membership.position.name}}</p>
                            </div>
                            <!-- Action Column -->
                            <div class="mt-3" v-if="authStore.hasPermission(['assign meeting position'])">
                                <div class="text-bold text-danger text-center mb-1" >
                                    Position
                                </div>
                                <div class="text-center">
                                    <MemberShipPosition
                                        :membership="membership"
                                        :positions="allPositions"
                                        :disableRemotePosition="0"
                                        @position-updated="handlePositionUpdated"
                                    />
                                </div>
                            </div>
                            <div class="mt-3" v-else>
                                <div class="text-bold text-danger text-center mb-1" >
                                    Position
                                </div>
                                <div class="text-center" >
                                    <i :class="'mr-2 fa ' + membership.position.icon" class="mr-2"></i> 
                                    {{ membership.position.name }}
                                </div>
                            </div>
                            <!-- Last Updated Column -->
                            <div class="mt-3">
                                <div class="text-bold text-danger text-center mb-1">
                                    Last Updated
                                </div>
                                <p class="text-center text-primary text-small">
                                    {{ formattedDateTime(membership.updated_at, null) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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

