<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {
  useCreateBoardMemberRequest,
    useGetBoardMembersRequest,
    useUpdateBoardMemberPositionRequest,
    useUpdateBoardMemberRequest,
} from '@/common/api/requests/modules/member/useMemberRequest';
import {useGetBoardPositionsRequest} from '@/common/api/requests/modules/member/usePositionRequest';
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
import {
    formattedDate,
    formattedDateTime, 
    loadAvatar,
    loadImage,    mapIconToRole,
    test,
    truncateDescription,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Member, MemberEditParams,MemberPositionRequestPayload,MemberRequestPayload,SelectedResult} from '@/common/parsers/memberParser';
import {Position} from '@/common/parsers/positionParser';
import {User} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';
import {Meta} from '@/common/types/types';
import MemberPosition from '@/staff/pages/secure/board/includes/MemberPosition.vue';
import Multiselect from '@@/@vueform/multiselect';


const authStore = useAuthStore();

//constants
const route = useRoute();
const router = useRouter();
const handleUnexpectedError = useUnexpectedErrorHandler();
const action = ref('create');
const boardId = route.params.boardId as string;
const showCreate = ref(false);
const membersmodal = ref<HTMLDialogElement | null>(null);
const selectedMemberIds = ref<string[]>([]);
const allUsers = ref<User[]>([]);

const {errorMessage} = useField('assignees');

const memberschema = yup.object({
    id: yup.string().nullable(),
    position_id: yup.string().nullable(),
    board_id: yup.mixed().required(),
    members: yup.array().of(yup.string()).nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    id: string;
    position_id: string;
    board_id: string;
    members: string[];

}>({
    validationSchema: memberschema,
    initialValues: {
        id: '',//member id for update user role
        position_id: '',
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
            await useCreateBoardMemberRequest(payload, boardId);
        } else if(action.value === 'edit') {
            await useUpdateBoardMemberRequest(payload, boardId);
        } else if(action.value === 'position') {
            const payload: MemberPositionRequestPayload = {
                id: values.id,
                position_id: values.position_id,
            };
            await useUpdateBoardMemberPositionRequest(payload, boardId);
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
    setFieldValue('position_id', '');
};

const getIconForPosition = (position: string) => {
    const iconMap: Record<string, string> = {
        member: 'fa fa-user',
        system: 'fa fa-cogs',
        admin: 'fa fa-user-shield',
        ceo: 'fa fa-user-tie',
        'company chairman': 'fa fa-chess-king',
        'company secretary': 'fa fa-user-secret',
        chairperson: 'fa fa-users',
        secretary: 'fa fa-user-circle',
        guest: 'fa fa-user-tag',
        observer: 'fa fa-binoculars',
        owner: 'fa fa-crown',  // Adding the icon for Owner
    };
    return iconMap[position.toLowerCase()] || 'fa fa-user';
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
const getBoardMembers = () => {
    return useQuery({
        queryKey: ['getBoardMembersKey', boardId],
        queryFn: async () => {
            const response = await useGetBoardMembersRequest(boardId, {paginate: 'false'});
            // console.log('response.data', response.data);
            return response.data;
        },
    });
};
const {isLoading, data: Members, refetch: fetchBoardMembers} = getBoardMembers();

// Fetch positions once and pass to child components
const allPositions = ref<Position[]>([]);
const getPositions = async () => {
    const data = await useGetBoardPositionsRequest({paginate: 'false'});
    allPositions.value = data.data;
};
onMounted(async () => {
    await getPositions();
});
const handlePositionUpdated = (event: { memberId: string; positionId: string }) => {
    reset();
    action.value = 'position';
    setFieldValue('id', event.memberId);
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

const onDeleteMember = async (id: string) => {
    await useDeleteMemberRequest(id);
    await fetchBoardMembers();
};

const roleIcon = ((roleType:string) => {
    return `mr-2 fa ${mapIconToRole(roleType)}`;
});

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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3" v-for="(member, idx) in Members" :key="idx">
                    <div class="card card-outline card-primary h-100">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <h3 class="profile-username text-center text-primary">
                                    <a href="" @click.prevent="
                                        authStore?.user?.id === member.user.id? openUserProfile(member.user):''">
                                        {{ member.user.full_name }}
                                    </a>
                                    <button v-if="authStore.hasPermission(['view board member profile'])"
                                            type="button" @click.prevent="openUserProfile(member.user)"
                                            title="" class="mx-2 btn btn-sm btn-primary">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </h3>
                                <p class="text-muted text-center text-bold">{{ member.position.name }}</p>
                            </div>
                            <!-- Action Column -->
                            <div class="mt-3" v-if="authStore.hasPermission(['assign board position'])">
                                <div class="text-bold text-danger text-center mb-1" >
                                    Position
                                </div>
                                <div class="text-center" >
                                    <MemberPosition
                                        :member="member"
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
                                    <i :class="'mr-2 fa ' + member.position.icon" class="mr-2"></i> 
                                    {{ member.position.name }}
                                </div>
                            </div>
                            <!-- Last Updated Column -->
                            <div class="mt-3">
                                <div class="text-bold text-danger text-center mb-1">
                                    Last Updated
                                </div>
                                <p class="text-center text-primary text-small">
                                    {{ formattedDateTime(member.updated_at, null) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>>

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

