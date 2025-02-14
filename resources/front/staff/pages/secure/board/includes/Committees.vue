<script setup lang="ts">
import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {nullable} from 'zod';
import {
    useCreateBoardRequest, 
    useDeleteBoardRequest, 
    useGetBoardsRequest,
    useUpdateBoardMembersRequest, 
    useUpdateBoardRequest,
} from '@/common/api/requests/modules/board/useBoardRequest';
import {
    useCreateCommitteeRequest, 
    useGetCommitteesRequest, 
    useUpdateCommitteeMembersRequest, 
    useUpdateCommitteeRequest,
} from '@/common/api/requests/modules/committee/useCommitteeRequest';
import {useGetStaffsRequest} from '@/common/api/requests/staff/useStaffRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormQuillEditor from '@/common/components/FormQuillEditor.vue';
import FormUpload from '@/common/components/FormUpload.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    coverChangeImage,
    iconChangeImage,
    loadIcon,
    resetCoverImage,
    resetIconImage,
    supportedImageTypes,
    updateCoverImage,
    updateIconImage,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Board, BoardMemberEditParams,BoardMembersRequestPayload,BoardRequestPayload} from '@/common/parsers/boardParser';
import {Committee, CommitteeMembersRequestPayload} from '@/common/parsers/committeeParser';
import {SelectedResult} from '@/common/parsers/membershipParser';
import {User} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';
const authStore = useAuthStore();

//constants
const route = useRoute();
const router = useRouter();

// Constants
const showCreate = ref(false);
const action = ref('create');
const boardId = route.params.boardId as string;
const selectedCommitteeId = ref(''); // for use when adding members
const selectedMemberIds = ref<string[]>([]);
const CommitteeModal = ref<HTMLDialogElement | null>(null);
const membersmodal = ref<HTMLDialogElement | null>(null);
const allUsers = ref<User[]>([]);

const handleUnexpectedError = useUnexpectedErrorHandler();

// Inputs forms handling
// Board schema
const fileSchema = yup.mixed().test(
    'fileOrString',
    'Must be a file or a string',
    value => (value instanceof File) || typeof value === 'string',
);
const schema = yup.object({
    name:  yup.string().required('Name is required'),
    description: yup.string().required('Description is required'),
    icon: fileSchema.required('Icon is required'),
    cover: fileSchema.required('Cover is required'),
});
const {
    handleSubmit, 
    setErrors, 
    setFieldValue, 
    values,
} = useForm<{
    name: string;
    description: string;
    icon: File | string;
    cover: File | string;
}>({
    validationSchema: schema,
    initialValues: {
        name: '',
        description: '',
        icon: '',
        cover: '',
    },
});

const onSubmit = handleSubmit(async (values) => {
    try { 
        const payload: BoardRequestPayload = {
            name: values.name,
            description: values.description,
            icon: values.icon,
            cover: values.cover,
        };
        if(action.value === 'create'){
            
            await useCreateCommitteeRequest(payload, boardId);
        }else if(action.value === 'edit'){      
            await useUpdateCommitteeRequest(payload, selectedCommitteeId.value);
        }
        CommitteeModal.value?.close(); 
        membersmodal.value?.close();
        await fetchCommittees();
        resetIconImage();
        resetCoverImage();
        resetForm();
        showCreate.value = false;  
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const onSubmitMembers = (async () => {
    try {
        const payload: CommitteeMembersRequestPayload = {
            members: selectedMemberIds.value,
        };
        await useUpdateCommitteeMembersRequest(payload, boardId, selectedCommitteeId.value); 
        membersmodal.value?.close();
        await fetchCommittees();
        resetForm();       
        showCreate.value = false;  
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const {errorMessage} = useField('members');

const openCreateModal = (value:string) => {
    action.value = 'create';       
    showCreate.value = true;
    CommitteeModal.value?.showModal();
};
const openEditModal = (e: Committee) => {
    // Set field values here
    setFieldValue('name', e.name);
    setFieldValue('description', e.description);
    setFieldValue('icon', e.icon);
    setFieldValue('cover', e.cover);
    updateCoverImage(e.cover);
    updateIconImage(e.icon);
    selectedCommitteeId.value = e.id as string;
    action.value = 'edit';
    showCreate.value = true;
    CommitteeModal.value?.showModal();
};
const resetForm = () => {
    // Set field values here
    setFieldValue('name', '');
    setFieldValue('description','');
    setFieldValue('icon', '');
    setFieldValue('cover', '');
    action.value = 'create';
    showCreate.value = true;
    selectedCommitteeId.value ='';
};

const openEditMembersModal = (params: BoardMemberEditParams, value:string) => {  
    const memberIds = params.members.map(member => member.user.id.toString());
    selectedMemberIds.value = memberIds; 
    action.value = 'members';
    selectedCommitteeId.value = params.id as string;
    // console.log('mm', selectedCommitteeId.value, selectedBoardId.value);
    showCreate.value = true;
    membersmodal.value?.showModal();
};

const selectedUsers = () => {
    // setFieldValue('members', selectedMemberIds.value);
};
const removeSelectedUsers = () => {
    // setFieldValue('members', selectedMemberIds.value);
};

const deleteBoard = async (board: Board) => {
    await useDeleteBoardRequest(board.id);
    await fetchCommittees();
};

const Users = computed(() => {
    const result: SelectedResult[] = [];
    if (allUsers.value && allUsers.value?.length > 0) {
        allUsers.value.reduce((accumulator, currentUser) => {
            accumulator.push({
                id: currentUser.id,
                name: `${currentUser.full_name}`,
            });
            return accumulator;
        }, result);
    }
    return result;
});
const getUsers = async () => {
    const data = await useGetStaffsRequest({paginate: 'false'});
    allUsers.value = data.data;
};
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Committees'}));
    getUsers();
});

const getCommittees = () => {
    return useQuery({
        queryKey: ['getCommitteesKey'],
        queryFn: async () => {
            const response = await useGetCommitteesRequest(boardId, {paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading:committeeloading, data: Committees, refetch: fetchCommittees} = getCommittees();
const actionLabel = computed(() => {
    if (action.value === 'create') return 'Create Committee';
    if (action.value === 'edit') return 'Edit Committee';
    return '';
});


</script>

<template>
    <div class="container-fluid" v-if="authStore.hasPermission(['view board'])">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h2 class="card-header-title h3">Committee</h2>
                        <div class="ml-auto flex items-center space-x-2">
                            <button class="btn btn-primary btn-sm"
                                    @click.prevent="openCreateModal('', 'committee')">
                                New Comittee
                            </button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <!-- Committees Column -->
                            <div class="col-md-4 col-12 d-flex" v-for="committee in Committees" :key="committee.id">
                                <div class="info-box shadow-lg p-4 mb-4 d-flex flex-column flex-grow-1">
                                    <div class="d-flex flex-column flex-grow-1 align-items-center">
                                        <img class="img-circle elevation-2" 
                                             :src="loadIcon(committee.icon)" 
                                             alt="User Avatar" 
                                             style="width:128px; height: 128px">
                                        <div class="ml-3 flex-1 w-100" v-if="committee.committeeable">
                                            <h3 class="h2 mb-2">
                                                <router-link 
                                                    :to="{ 
                                                        name: 'CommitteeDetails', 
                                                        params: { 
                                                            committeeId: committee.id, 
                                                            boardId: committee.committeeable.details.id
                                                        }
                                                    }" class="badge badge-soft bg-primary text-wrap">
                                                    {{ committee.name }}
                                                </router-link>
                                            </h3>
                                            <h3 class="mb-1"  v-if="committee.committeeable">
                                                Board: <router-link 
                                                    :to="{ 
                                                        name: 'BoardDetails', 
                                                        params: { 
                                                            boardId: committee.committeeable.details.id 
                                                        }
                                                    }" class="badge badge-soft text-wrap">
                                                    {{ committee.committeeable.details.name }}
                                                </router-link>
                                            </h3>
                                            <p class="text-gray-900 m-0">
                                                Owner: {{ committee.owner }}
                                            </p>
                                            <div v-if="committee.members">
                                                <span>
                                                    {{ committee.members.length }} 
                                                    {{ committee.members.length === 1 ? 'Member' : 'Members' }}
                                                </span>
                                                <br>
                                                <a v-if="authStore.hasPermission(['add member to committee'])"
                                                   href=""
                                                   @click.prevent="openEditMembersModal(committee)"
                                                   class="text-blue-500 hover:text-blue-700 
                               transition duration-150 ease-in-out">
                                                    <i class="fa fa-plus mr-2"></i> Members
                                                </a>
                                            </div>
                                            <p class="text-muted m-0 truncate" v-html="committee.description"></p>
                                        </div><!-- /.info-box-content -->
                                    </div>
                                    <div class="d-flex justify-content-end mt-2 w-100">
                                        <a v-if="authStore.hasPermission(['edit committee'])"
                                           href=""
                                           @click.prevent="openEditModal(committee)"
                                           class="text-blue-500 hover:text-blue-700 
                       transition duration-150 ease-in-out mr-2">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a v-if="authStore.hasPermission(['delete committee'])"
                                           href=""
                                           @click.prevent="deleteCommittee(committee)"
                                           class="text-blue-500 hover:text-blue-700 
                       transition duration-150 ease-in-out mr-2">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                        <router-link v-if="authStore.hasPermission(['view committee']) && committee.committeeable"
                                                     :to="{ 
                                                         name: 'CommitteeDetails', 
                                                         params: { 
                                                             committeeId: committee.id,
                                                             boardId: committee.committeeable.details.id 
                                                         } 
                                                     }"
                                                     class="text-green-500 hover:text-green-700
                                  transition duration-150 ease-in-out">
                                            <i class="fa fa-eye"></i>
                                        </router-link>
                                    </div>
                                </div>
                            </div><!-- /.col-md-4 -->
                        </div><!-- /.row -->
                    </div><!-- /.card-body -->

                    
                </div><!-- /.card -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
        <div class="flex justify-center items-center min-h-screen">
            <dialog id="CommitteeModal" class="modal w-full max-w-4xl mx-auto p-0" ref="CommitteeModal">
                <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                    <h3 class="font-bold text-lg text-center">
                        {{ actionLabel  }}
                    </h3>
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            
                    <div class="overflow-auto p-4" style="max-height: 80vh;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-2">
                            <!-- Board form -->
                            <div class="col-span-2">
                                <form novalidate @submit.prevent="onSubmit" class="">
                                    <div class="flex flex-wrap -mx-2">
                                        <div class="w-full md:w-1/3 px-1 md:px-2 mb-4">
                                            <FormInput
                                                :labeled="true"
                                                label="Name"
                                                name="name"
                                                class="w-full text-sm  text-white tracking-wide"
                                                placeholder="Enter Name"
                                                type="text"
                                            />
                                        </div>
                                        <div class="w-full md:w-1/3 px-1 md:px-2 mb-4">
                                            <FormUpload
                                                :labeled="true"
                                                label="Upload icon Image"
                                                name="icon"
                                                class="w-full text-sm  text-white tracking-wide"
                                                placeholder="Enter icon Image"
                                                type="file"
                                                :accept="supportedImageTypes.join(', ')"
                                                @change="iconChangeImage($event)"
                                            />
                                            <img   :src="updateIconImage(values?.icon)"
                                                   class="file_attachment"/>
                                        </div>
                                        <div class="w-full md:w-1/3 px-1 md:px-2 mb-4">
                                            <FormUpload
                                                :labeled="true"
                                                label="Upload Cover Image"
                                                name="cover"
                                                class="w-full text-sm  text-white tracking-wide"
                                                placeholder="Enter Cover Image"
                                                type="file"
                                                :accept="supportedImageTypes.join(', ')"
                                                @change="coverChangeImage($event)"
                                            />
                                            <img   :src="updateCoverImage(values.cover)"
                                                   class="file_attachment"/>
                                        </div>
                                    </div>
                                    <FormQuillEditor
                                        label="Description"
                                        name="description"
                                        theme="snow"
                                        placeholder="Enter Description"
                                        toolbar="full"
                                        contentType="html"
                                        class="col-span-3 mb-4"
                                    />
                                    <button type="submit" class="btn btn-primary btn-md w-full mt-6">
                                        {{actionLabel  }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </dialog>
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
                            <form novalidate @submit.prevent="onSubmitMembers"
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
                                        @deselect="removeSelectedUsers()"
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
    </div>
    <div class="container-fluid" v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>     
</template>
<style scoped>

.btn-info {
  background-color: #17a2b8;
  color: #fff;
}

.products-list .product-info {
    margin-left: 129px!important;
}
</style>
