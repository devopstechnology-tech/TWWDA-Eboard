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
    useCreateBoardRequest, 
    useDeleteBoardRequest, 
    useGetBoardsRequest,
    useUpdateBoardMembersRequest, 
    useUpdateBoardRequest,
} from '@/common/api/requests/modules/board/useBoardRequest';
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
    resetCoverImage,
    resetIconImage,
    supportedImageTypes,
    updateCoverImage,
    updateIconImage,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Board, BoardMemberEditParams,BoardRequestPayload} from '@/common/parsers/boadParser';
import {SelectedResult} from '@/common/parsers/membershipParser';
import {User} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();

// Constants
const showCreate = ref(false);
const action = ref('create');
const selectedBoard = ref<Board | null>(null);
const selectedBoardId = ref(''); // for use when adding members
const selectedMemberIds = ref<string[]>([]);
const BoardModal = ref<HTMLDialogElement | null>(null);
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
        if(action.value === 'create'|| action.value === 'edit'){
            const payload: BoardRequestPayload = {
                name: values.name,
                description: values.description,
                icon: values.icon,
                cover: values.cover,
            };
            if(action.value === 'create'){
                await useCreateBoardRequest(payload);
            }else if(action.value === 'edit'){
                if (selectedBoard.value?.id) {
                    console.log('Selected Board ID:', selectedBoard.value.id);
                    await useUpdateBoardRequest(payload, selectedBoard.value.id);
                }
            }
        }
        BoardModal.value?.close(); 
        membersmodal.value?.close();  
        await fetchBoards();
        resetIconImage();
        resetCoverImage();
        resetBoardForm();
        selectedMemberIds.value = [];
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
        if (selectedBoardId.value) {
            const payload: BoardRequestPayload = {
                members: selectedMemberIds.value,
            };
            await useUpdateBoardMembersRequest(payload, selectedBoardId.value);                
        }
        membersmodal.value?.close();  
        await fetchBoards();
        resetBoardForm();
        selectedMemberIds.value = [];
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

const openCreateModal = () => {
    action.value = 'create';
    showCreate.value = true;
    BoardModal.value?.showModal();
};
const openEditModal = (e: Board) => {
    selectedBoard.value = e;
    // Set field values here
    setFieldValue('name', e.name);
    setFieldValue('description', e.description);
    setFieldValue('icon', e.icon);
    setFieldValue('cover', e.cover);
    updateCoverImage(e.cover);
    updateIconImage(e.icon);
    action.value = 'edit';
    showCreate.value = true;
    BoardModal.value?.showModal();
};
const resetBoardForm = () => {
    // Set field values here
    setFieldValue('name', '');
    setFieldValue('description','');
    setFieldValue('icon', '');
    setFieldValue('cover', '');
    action.value = 'create';
    showCreate.value = true;
};

// const onSubmitMembers = handleSubmitMembers(async (values) => {
//     try {
//         if (selectedBoardId.value) {
//             setFieldValueMembers('members', selectedMemberIds.value);
//             await useUpdateBoardMembersRequest(values, selectedBoardId.value);
//         }
//         selectedMemberIds.value = [];
//         await fetchBoards();
//         showCreate.value = false;
//         membersmodal.value?.close();
//     } catch (err) {
//         if (err instanceof ValidationError) {
//             setErrorsMembers(err.messages);
//         } else {
//             handleUnexpectedError(err);
//         }
//     }
// });

const openEditMembersModal = (params: BoardMemberEditParams) => {
    selectedBoardId.value = params.id; // Store the board ID
    const memberIds = params.members.map(member => member.user.id.toString());
    selectedMemberIds.value = memberIds; 
    action.value = 'members';
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
    await fetchBoards();
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
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Boards & Boards'}));
    getUsers();
});
const getBoards = () => {
    return useQuery({
        queryKey: ['getBoardsKey'],
        queryFn: async () => {
            const response = await useGetBoardsRequest({paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading, data: Boards, refetch: fetchBoards} = getBoards();
</script>

<template>
    <div class="container-fluid" v-if="authStore.hasPermission(['view board'])">
        <div class="row">
            <div class="col-12">
                <!-- Custom Tabs -->
                <div class="">
                    <div class="card-header">
                        <div class="float-left">
                            <h1 class="h2 mb-2 lg:mb-0">Boards & Boards</h1>
                        </div>
                        <div class="float-right" >
                            <button @click.prevent="openCreateModal" type="submit" class="btn btn-secondary bg-primary">
                                <i class="far fa fa-plus mr-2 "></i>New Board
                            </button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-12" v-if="Boards">
                                <div class="info-box shadow-lg p-6" v-for="board in Boards" :key="board.id">
                                    <span class="info-box-icon bg-danger"><i :class="board.icon"></i></span>
                                    <div class="ml-3 flex-1">
                                        <h3 class="h2 mb-2 lg:mb-0">
                                            <router-link :to="{ name: 'BoardDetails', params: { boardId: board.id } }">
                                                {{ board.name }}
                                            </router-link>
                                        </h3>
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 lg:gap-2">
                                            <p class="text-gray-900 m-0 col-span-1 lg:col-span-2">
                                                Owner: {{board.owner}}
                                            </p>
                                            <p class="text-gray-900 m-0 col-span-1 lg:col-span-1" v-if="board.members">
                                                <span v-if="board.members?.length > 1">
                                                    {{ board.members?.length }} Members
                                                </span>
                                                <span v-else-if="board.members?.length === 1">
                                                    {{ board.members?.length }} Member
                                                </span>
                                                <span v-else>No Members, Add</span>
                                                <br>
                                                <a v-if="authStore.hasPermission([
                                                       'add member to board',
                                                       'edit board member',
                                                       'remove board member',
                                                   ])" 
                                                   href=""
                                                   @click.prevent="openEditMembersModal(
                                                       { id: board.id,
                                                         members: board.members?board.members:[]
                                                       })"
                                                   class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                    <i class="far fa fa-plus mr-2 "></i> Members
                                                </a>
                                            </p>
                                            <div class="text-muted m-0 col-span-1 lg:col-span-7 truncate"
                                                 v-html="board.description"></div>
                                            <div class="flex justify-end space-x-2 col-span-1 lg:col-span-2">
                                                <!-- Edit Button/Link -->
                                                <a v-if="authStore.hasPermission(['edit board'])" 
                                                   href="" @click.prevent="openEditModal(board)"
                                                   class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a v-if="authStore.hasPermission(['delete board'])"
                                                   href="" @click.prevent="deleteBoard(board)"
                                                   class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                <!-- View Button/Link -->
                                                <router-link v-if="authStore.hasPermission(['view board'])" 
                                                             :to="{ name: 'BoardDetails', params: { boardId: board.id } }"
                                                             class="text-green-500
                                                hover:text-green-700 transition duration-150 ease-in-out">
                                                    <i class="far fa-eye"></i>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                <!-- /.info-box-content -->
                                </div>
                            </div>
                            <div class="col-md-12 col-12" v-else>
                                <div class="info-box shadow-lg p-6" >
                                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                                    <div class="ml-3 flex-1">
                                        <h3 class="h2 mb-2 lg:mb-0">
                                            <a href="">
                                                create Board
                                            </a>
                                        </h3>
                                    </div>
                                <!-- /.info-box-content -->
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            <!-- ./card -->
            </div>
        </div>
        <div class="flex justify-center items-center min-h-screen">
            <dialog id="boardModal" class="modal w-full max-w-4xl mx-auto p-0" ref="BoardModal">
                <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                    <h3 class="font-bold text-lg text-center">
                        {{ action == 'create' ? 'Create Board' : 'Edit Board' }}
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
                                                label="Board/Board Name"
                                                name="name"
                                                class="w-full text-sm  text-white tracking-wide"
                                                placeholder="Enter Board/Board Name"
                                                type="text"
                                            />
                                        </div>
                                        <div class="w-full md:w-1/3 px-1 md:px-2 mb-4">
                                            <FormUpload
                                                :labeled="true"
                                                label="Upload icon Image for the Board"
                                                name="icon"
                                                class="w-full text-sm  text-white tracking-wide"
                                                placeholder="Enter icon Image of the Board"
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
                                                label="Upload Cover Image for the Board"
                                                name="cover"
                                                class="w-full text-sm  text-white tracking-wide"
                                                placeholder="Enter Cover Image of the Board"
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
                                        placeholder="Enter Board Description"
                                        toolbar="full"
                                        contentType="html"
                                        class="col-span-3 mb-4"
                                    />
                                    <button type="submit" class="btn btn-primary btn-md w-full mt-6">
                                        {{action == 'create' ? 'Create Board' : 'Edit Board'}}
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
