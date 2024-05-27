
<script setup lang="ts">
import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import * as yup from 'yup';
import {
    useCreateCommitteeRequest,
    useDeleteCommitteeRequest,
    useGetCommitteesRequest,
    useUpdateCommitteeMembersRequest,
    useUpdateCommitteeRequest} from '@/common/api/requests/modules/committee/useCommitteeRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {Committee, CommitteeMemberParser} from '@/common/parsers/committeeParser';
import {User} from '@/common/parsers/userParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';

const showCreate = ref(false);
const action = ref('create');
const selectedCommittee = ref<Committee | null>(null);
const modal = ref<HTMLDialogElement | null>(null);
const membersmodal = ref<HTMLDialogElement | null>(null);
const selectedMemberIds = ref<string[]>([]);
const selectedCommitteeId = ref(''); // for use whenadding members
const page = ref(1);
const perPage = ref(15);
const meta = ref<Meta>();
const allUsers = ref<User[]>([]);

interface SelectedResult {
    id: number,
    name: string,
}
interface CommitteeEditParams {
    id: string;
    members: { id: string; full_name: string; }[];
}

const selectedUsers = () => {
    setFieldValueMembers('members', selectedMemberIds.value);
};
const removeselectedUsers = () => {
    setFieldValueMembers('members', selectedMemberIds.value);
};



// const openEditMembersModal = (params: CommitteeEditParams) => {

//     selectedCommitteeId.value = params.id; // Store the committee ID
//     const memberIds = params.members.map(member => member.id.toString());
//     selectedMemberIds.value = memberIds; // Update the ref with the new array
const openEditMembersModal = (params: CommitteeEditParams) => {
    console.log('params.members', params.members);
    selectedCommitteeId.value = params.id; // Store the committee ID
    const memberIds = params.members.map(member => member.id.toString());
    selectedMemberIds.value = memberIds; // Update the ref with the new array
    setFieldValueMembers('members', selectedMemberIds.value);
    console.log('memberIds', memberIds);
    console.log('selectedMemberIds', selectedMemberIds);
    action.value = 'edit';
    showCreate.value = true;
    membersmodal.value?.showModal();
};

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
const {errorMessage} = useField('members');



const onSubmitMembers = handleSubmitMembers(async (values) => {
    console.log('Submitting form with values:', values);
    try {
        if (selectedCommitteeId.value) {
            // Pass the whole form values, assuming the backend expects an object
            // with `name`, `description`, `icon`, `cover`, and `members` fields.
            setFieldValueMembers('members', selectedMemberIds.value);
            await useUpdateCommitteeMembersRequest(values, selectedCommitteeId.value);
        }
        // Additional logic to handle the response, close modals, etc.
        selectedMemberIds.value = [];
        await fetchCommittees();
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

const openCreateModal = () => {
    action.value = 'create';
    showCreate.value = true;
    modal.value?.showModal();
};
const openEditModal = (e: Committee) => {
    selectedCommittee.value = e;
    // Set field values here
    setFieldValue('name', e.name);
    setFieldValue('description', e.description);
    setFieldValue('icon', e.icon);
    setFieldValue('cover', e.cover);
    action.value = 'edit';
    showCreate.value = true;
    modal.value?.showModal();
};
const handleUnexpectedError = useUnexpectedErrorHandler();

const schema = yup.object({
    name: yup.string().required(),
    description: yup.string().required(),
    icon: yup.string().required(),
    cover: yup.string().required(),
});
const {handleSubmit, setErrors, setFieldValue, values} = useForm<{
    name: string;
    description: string;
    icon: string;
    cover: string;
}>({
    validationSchema: schema,
    initialValues: {
        name: '',
        description: '',
        icon: '',
        cover: '',
    },
});

const deleteCommittee = async (e: string) => {
    await useDeleteCommitteeRequest(e);
    await fetchCommittees();
};

const onSubmit = handleSubmit(async (values) => {
    try {
        if (action.value === 'create') {
            await useCreateCommitteeRequest(values);
        } else {
            if (selectedCommittee.value?.id) {
                await useUpdateCommitteeRequest(values, selectedCommittee.value?.id);
            }
        }
        await fetchCommittees();
        showCreate.value = false;
        modal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});


const getCommittees = () => {
    return useQuery({
        queryKey: ['getCommitteesKey', page.value, perPage.value], queryFn: async () => {
            const response = await useGetCommitteesRequest({
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
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Boards & Committees'}));
    getUsers();
});
function truncateDescription(description: string, maxLength: number): string {
    return description?.length > maxLength ? description.substring(0, maxLength) + '...' : description;
}
// console.log('users', users);
const iconTypes = [
    {name: 'fa-edit', value: 'far fa-edit'},
    {name: 'fa-star', value: 'far fa-star'},
    {name: 'fa-eye', value: 'far fa-eye'},
    {name: 'fa-trash-alt', value: 'far fa-trash-alt'},
    {name: 'fa-check-circle', value: 'far fa-check-circle'},
    {name: 'fa-times-circle', value: 'far fa-times-circle'},
    {name: 'fa-envelope', value: 'far fa-envelope'},
    {name: 'fa-comments', value: 'far fa-comments'},
    {name: 'fa-heart', value: 'far fa-heart'},
    {name: 'fa-share-square', value: 'far fa-share-square'},
    {name: 'fa-bookmark', value: 'far fa-bookmark'},
    {name: 'fa-calendar-alt', value: 'far fa-calendar-alt'},
    {name: 'fa-copy', value: 'far fa-copy'},
    {name: 'fa-folder', value: 'far fa-folder'},
    {name: 'fa-paper-plane', value: 'far fa-paper-plane'},
    {name: 'fa-clipboard', value: 'far fa-clipboard'},
    {name: 'fa-clock', value: 'far fa-clock'},
    {name: 'fa-bell', value: 'far fa-bell'},
    {name: 'fa-flag', value: 'far fa-flag'},
    {name: 'fa-life-ring', value: 'far fa-life-ring'},
];

const {isLoading, data, refetch: fetchCommittees} = getCommittees();
</script>
<template>
    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="">
                <div class="card-header">
                    <div class="float-left">
                        <h1 class="h2 mb-2 lg:mb-0">Boards & Committees</h1>
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
                            <div class="info-box shadow-lg p-6" v-for="committee in data" :key="committee.id">
                                <span class="info-box-icon bg-danger"><i :class="committee.icon"></i></span>
                                <div class="ml-3 flex-1">
                                    <h3 class="h2 mb-2 lg:mb-0">
                                        <router-link :to="{ name: 'BoardDetails', params: { id: committee.id } }">
                                            {{ committee.name }}
                                        </router-link>
                                    </h3>
                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 lg:gap-2">
                                        <p class="text-gray-900 m-0 col-span-1 lg:col-span-2">
                                            Owner: {{committee.owner}}
                                        </p>
                                        <p class="text-gray-900 m-0 col-span-1 lg:col-span-1" v-if="committee.members">
                                            <span v-if="committee.members?.length > 1">
                                                {{ committee.members?.length }} Members
                                            </span>
                                            <span v-else-if="committee.members?.length === 1">
                                                {{ committee.members?.length }} Member
                                            </span>
                                            <span v-else>No Members, Add</span>
                                            <br>
                                            <a href=""
                                               @click.prevent="openEditMembersModal(
                                                   { id: committee.id,
                                                     members: committee.members?committee.members:[]
                                                   })"
                                               class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                <i class="far fa fa-plus mr-2 "></i> Members
                                            </a>
                                        </p>
                                        <div class="text-muted m-0 col-span-1 lg:col-span-7 truncate">
                                            {{ truncateDescription(committee.description, 80)}}
                                        </div>
                                        <div class="flex justify-end space-x-2 col-span-1 lg:col-span-2">
                                            <!-- Edit Button/Link -->
                                            <a href="" @click.prevent="openEditModal(committee)"
                                               class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <!-- View Button/Link -->
                                            <router-link :to="{ name: 'BoardDetails', params: { id: committee.id } }"
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
                                            create Committee
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
    <div class="flex justify-center col-md-6">
        <dialog id="boardmodal" class="modal" ref="modal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{action == 'create' ? 'Create Board Or Committee' : 'Edit Board Or Committee'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    label="Board/Committee Name"
                                    name="name"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Board/Committee Name"
                                    type="text"
                                />
                                <FormSelect name="icon"
                                            label="Select Business Types"
                                            :options="iconTypes"/>
                                <FormInput
                                    label="Cover Image of Board"
                                    name="cover"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Cover Image of the Board"
                                    type="text"
                                />
                                <!-- <div class="col-span-3"> -->
                                <FormTextBox
                                    label="Board/Committee Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Board/Committee Description"
                                    :rows="2"
                                />
                                <!-- </div> -->
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{action == 'create' ? 'Create Board Or Committee' : 'Edit Board Or Committee'}}
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
