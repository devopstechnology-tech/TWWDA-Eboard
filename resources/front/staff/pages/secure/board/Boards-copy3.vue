
<script setup lang="ts">
import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import {GenericObject, useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import * as yup from 'yup';
import {
    useCreateBoardRequest,
    useGetBoardsRequest,
    useUpdateBoardRequest,
} from '@/common/api/requests/modules/board/useBoardRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import FormUpload from '@/common/components/FormUpload.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {iconTypes,truncateDescription} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {BoardRequest, BoardRequestPayload} from '@/common/parsers/boadParser';
import {User} from '@/common/parsers/userParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';
//constants
const page = ref(1);
const perPage = ref(15);
const meta = ref<Meta>();
const showCreate = ref(false);
const action = ref('create');
const allUsers = ref<User[]>([]);
const selectedBoard = ref<BoardRequest | null>(null);
const boardmodal = ref<HTMLDialogElement | null>(null);
const membersmodal = ref<HTMLDialogElement | null>(null);
const selectedMemberIds = ref<string[]>([]);
const selectedBoardId = ref(''); // for use whenadding members
const selectedUsers = () => {
    setFieldValueMembers('members', selectedMemberIds.value);
};
const removeselectedUsers = () => {
    setFieldValueMembers('members', selectedMemberIds.value);
};

// errors
const handleUnexpectedError = useUnexpectedErrorHandler();
const {errorMessage} = useField('members');
//inputs forms handling

const schema = yup.object({
    name: yup.string().required(),
    description: yup.string().required(),
    icon: yup.string().required(),
    cover: yup.mixed().required(), //file
});
const {handleSubmit, setErrors, setFieldValue, values} = useForm<{
    name: string;
    description: string;
    icon: string;
    cover: File;
}>({
    validationSchema: schema,
    initialValues: {
        name: '',
        description: '',
        icon: '',
        cover: '',
    },
});

const membersschema = yup.object({
    members: yup.array().of(yup.string()).required('Members selection is required.'),
});

const {
    handleSubmit: handleSubmitMembers,
    setErrors: setErrorsMembers,
    setFieldValue: setFieldValueMembers,
} = useForm<{
    members: string[];
}>({
    validationSchema: membersschema,
    initialValues: {
        members: [],
    },
});

// modals
const openCreateModal = () => {
    action.value = 'create';
    showCreate.value = true;
    boardmodal.value?.showModal();
};
const openEditModal = (e: BoardRequest) => {
    selectedBoard.value = e;
    // Set field values here
    setFieldValue('name', e.name);
    setFieldValue('description', e.description);
    setFieldValue('icon', e.icon);
    setFieldValue('cover', e.cover ?? '');
    action.value = 'edit';
    showCreate.value = true;
    boardmodal.value?.showModal();
};

// const openEditMembersModal = (params: BoardEditParams) => {
//     console.log('params.members', params.members);
//     selectedBoardId.value = params.id; // Store the board ID
//     const memberIds = params.members.map(member => member.id.toString());
//     selectedMemberIds.value = memberIds; // Update the ref with the new array
//     setFieldValueMembers('members', selectedMemberIds.value);
//     console.log('memberIds', memberIds);
//     console.log('selectedMemberIds', selectedMemberIds);
//     action.value = 'edit';
//     showCreate.value = true;
//     membersmodal.value?.showModal();
// };
// data

// onmount
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Boards'}));
    // getUsers();
});

// computed

// methods/functions
const getBoards = () => {
    return useQuery({
        queryKey: ['getBoardsKey', page.value, perPage.value], queryFn: async () => {
            const response = await useGetBoardsRequest({
                page: page.value,
                perPage: perPage.value,
            });
            meta.value = response.data.meta;
            return response.data.data;
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

const onSubmit = handleSubmit(async (values: GenericObject) => {
    try {
        // Explicitly validate and cast values to BoardRequestPayload
        const payload: BoardRequestPayload = {
            name: values.name,
            description: values.description,
            icon: values.icon,
            cover: values.cover instanceof File ? values.cover : new File([], ''), // Fallback if not a file
        };
        console.log('payload', payload);
        if (action.value === 'create') {
            await useCreateBoardRequest(payload);
        } else {
            if (selectedBoard.value?.id) {
                await useUpdateBoardRequest(payload, selectedBoard.value?.id);
            }
        }
        // await fetchBoards();
        showCreate.value = false;
        boardmodal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const onSubmitMembers = handleSubmitMembers(async (values) => {
    console.log('Submitting form with values:', values);
    try {
        if (selectedBoardId.value) {
            // Pass the whole form values, assuming the backend expects an object
            // with `name`, `description`, `icon`, `cover`, and `members` fields.
            setFieldValueMembers('members', selectedMemberIds.value);
            // await useUpdateBoardMembersRequest(values, selectedBoardId.value);
        }
        // Additional logic to handle the response, close modals, etc.
        selectedMemberIds.value = [];
        await fetchBoards();
        showCreate.value = false;
        membersmodal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrorsMembers(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
//default loading
const {isLoading, data, refetch: fetchBoards} = getBoards();
</script>
<template>
    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="">
                <div class="card-header">
                    <div class="float-left">
                        <h1 class="h2 mb-2 lg:mb-0">Boards</h1>
                    </div>
                    <div class="float-right">
                        <button @click.prevent="openCreateModal" type="submit" class="btn btn-secondary bg-primary">
                            <i class="far fa fa-plus mr-2 "></i>New Board
                        </button>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-12" v-if="data">
                            <div class="info-box shadow-lg p-6" v-for="board in data" :key="board.id">
                                <span class="info-box-icon bg-danger"><i :class="board.icon"></i></span>
                                <div class="ml-3 flex-1">
                                    <h3 class="h2 mb-2 lg:mb-0">
                                        <router-link :to="{ name: 'BoardDetails', params: { id: board.id } }">
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
                                            <a href=""
                                               @click.prevent="openEditMembersModal(
                                                   { id: board.id,
                                                     members: board.members?board.members:[]
                                                   })"
                                               class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                <i class="far fa fa-plus mr-2 "></i> Members
                                            </a>
                                        </p>
                                        <div class="text-muted m-0 col-span-1 lg:col-span-7 truncate">
                                            {{ truncateDescription(board.description, 80)}}
                                        </div>
                                        <div class="flex justify-end space-x-2 col-span-1 lg:col-span-2">
                                            <!-- Edit Button/Link -->
                                            <a href="" @click.prevent="openEditModal(board)"
                                               class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <!-- View Button/Link -->
                                            <router-link :to="{ name: 'BoardDetails', params: { id: board.id } }"
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
                        <div class="col-md-12 col-12" v-if="!data">
                            <div class="info-box shadow-lg p-6" >
                                <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                                <div class="ml-3 flex-1">
                                    <h3 class="h2 mb-2 lg:mb-0">
                                        <button @click.prevent="openCreateModal" type="submit"
                                                class="btn btn-secondary bg-primary">
                                            <i class="far fa fa-plus mr-2 "></i>New Board
                                        </button>
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
    <div class="flex justify-center col-md-6">
        <dialog id="boardmodal" class="modal" ref="boardmodal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{action == 'create' ? 'Create Board' : 'Edit Board'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    label="Board/Board Name"
                                    name="name"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Board/Board Name"
                                    type="text"
                                />
                                <FormSelect name="icon"
                                            label="Select Business Types"
                                            :options="iconTypes"/>
                                <!-- <FormInput
                                    label="Cover Image of Board"
                                    name="cover"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Cover Image of the Board"
                                    type="text"
                                /> -->
                                <FormUpload
                                    label="Upload Cover Image for the Board"
                                    name="cover"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Cover Image of the Board"
                                    type="file"
                                />
                                <!-- <div class="col-span-3"> -->
                                <FormTextBox
                                    label="Board/Board Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Board/Board Description"
                                    :rows="2"
                                />
                                <!-- </div> -->
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{action == 'create' ? 'Create Board' : 'Edit Board'}}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="boardmodal" class="modal" ref="membersmodal">
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
                            <!-- <FormMultiSelect
                                name="members"
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
                                valueProp="'id'"
                                trackBy="'id'"
                                label="name"
                                labelProp="Members"
                                class=""
                                @select="selectedUsers()"
                                @deselect="removeselectedUsers()"
                            /> -->

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

</style>



