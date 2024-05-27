
<script lang="ts" setup>
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, Ref,ref} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import * as yup from 'yup';
import {
    useCreateAgendaRequest,
    useCreateSubAgendaRequest,
    useGetMeetingAgendasRequest,
    useUpdateAgendaRequest,
    useUpdateSubAgendaRequest,
} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import {useGetMeetingMembersRequest} from '@/common/api/requests/modules/meeting/useMeetingMemberRequest';
import {useGetMembershipsRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formatAgendaEntry,        formatDuration,
    resetCoverImage,
    resetIconImage, truncateDescription} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Agenda, AgendaRequestPayload} from '@/common/parsers/agendaParser';
import {
    BoardRequestPayload,
    SelectedResult,
} from '@/common/parsers/boadParser';
import {Membership} from '@/common/parsers/membershipParser';
import Multiselect from '@@/@vueform/multiselect';


const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const action = ref('create');
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const agendaId = ref<string | null>(null);
const selectedMembershipIds = ref<string[]>([]);
const allMemberships = ref<Membership[]>([]);
const selectedAgenda = ref<Agenda | null>(null);

const items = ref([]);
const is_editing = ref(false);
const isAddingNewParent = ref(false);
const addingChild = ref(false);
const currentParentId = ref<string | null>(null);
const editingParentIndex = ref(-1);
const editingChildIndex = ref(-1);

const {errorMessage} = useField('assignees');
//oneagnda
const agendaschema = yup.object({
    meeting_id: yup.mixed().required(),
    title: yup.string().required(),
    duration: yup.number().nullable(),
    description: yup.string().nullable(),
    agenda_id: yup.string().nullable(),
    assignees: yup.array().of(yup.string()).nullable(),
    children: yup.array().of(yup.string()).nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    meeting_id: string;
    title: string;
    duration: number | null,
    description: string | null,
    agenda_id: string | null,
    assignees: string[],
    children: string[],

}>({
    validationSchema: agendaschema,
    initialValues: {
        meeting_id: meetingId,
        title: '',
        duration: null,
        description:null,
        agenda_id: null,
        assignees: [],
        children: [],
    },
});

const enableAddingNewParent = () => {
    isAddingNewParent.value = true;
    is_editing.value = false;
    addingChild.value = false;
    editingParentIndex.value = -1;
    editingChildIndex.value = -1;
    action.value = 'create';
    // form.value.data.text = '';
    setFieldValue('title', '');
    console.log(
        'we are here',
        isAddingNewParent.value,
        addingChild.value,
        items,
    );
};

const enableAddingChild = (pIndex, parentid:string) => {
    addingChild.value = true;
    currentParentId.value = parentid; // Identify the parent
    editingParentIndex.value = pIndex; // Keep track of the parent being edited
    editingChildIndex.value = -1; // Reset child index since we're adding a new child
    // form.value.data.text = ''; // Clear the form for new input
    setFieldValue('title', '');
    is_editing.value = false; // Ensure we're not in editing mode
    action.value = 'create';
};

const enableEditing = (pIndex, cIndex, agenda:Agenda) => {
    selectedAgenda.value = agenda;
    agendaId.value = agenda.id;


    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;
    action.value = 'edit';

    // defaultpopulation
    setFieldValue('title',  agenda.title);
    setFieldValue('meeting_id', meetingId);
    setFieldValue('duration', agenda.duration);
    setFieldValue('description', agenda.description);


    if (agenda.assignees){
        const assigneeIds = agenda.assignees.map(assignee => assignee.id);
        selectedMembershipIds.value = assigneeIds;
        setFieldValue('assignees', assigneeIds);
    } else {
        setFieldValue('assignees', []);
    }
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    console.log('1, useUpdateSubAgendaRequest', 'update child', editingChildIndex.value);
    try {
        if (action.value === 'create') {
            const payload: AgendaRequestPayload = {
                title: values.title,
                meeting_id: values.meeting_id,
                duration: null,
                description: null,
                agenda_id: null,
                assignees: [],
                children: [],
            };
            if(addingChild.value)
            {
                const agenda_id = currentParentId.value ? currentParentId.value.toString() : null;
                payload.agenda_id = agenda_id,
                await useCreateSubAgendaRequest(payload, meetingId);
            }
            else if(isAddingNewParent.value)
            {
                await useCreateAgendaRequest(payload, meetingId);
            }
        } else {
            console.log('3 useUpdateSubAgendaRequest', 'update child', editingChildIndex.value);
            const payload: AgendaRequestPayload = {
                title: values.title,
                meeting_id: values.meeting_id,
                duration: values.duration,
                description: values.description,
                agenda_id: null,
                assignees: [],
                children: [],
            };
            if(editingChildIndex.value !== -1){
                // update child
                console.log('useUpdateSubAgendaRequest', 'update child', editingChildIndex.value);
                payload.assignees = values.assignees;
                const agenda_id = agendaId.value ? agendaId.value.toString() : null;
                payload.agenda_id = agenda_id,
                await useUpdateSubAgendaRequest(payload, meetingId);
            }
            else if(editingParentIndex.value !== -1){
                // update parent
                payload.assignees = values.assignees;
                const agenda_id = agendaId.value ? agendaId.value.toString() : null;
                payload.agenda_id = agenda_id,
                await useUpdateAgendaRequest(payload, meetingId);
            }

            // if (selectedBoard.value?.id) {
            //     console.log('Selected Board ID:', selectedBoard.value.id);
            //     await useUpdateBoardRequest(
            //         payload,
            //         selectedBoard.value.id,
            //     );
            // }
        }
        await fetchMeetingAgendas();
        resetForm();
        cancelEditing();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const cancelEditing = () => {
    action.value = 'create';
    is_editing.value = false;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = -1;
    editingChildIndex.value = -1;
    selectedAgenda.value = null;
    agendaId.value =null;
    selectedMembershipIds.value = [];

    setFieldValue('title',  '');
    setFieldValue('duration', null);
    setFieldValue('description', null);
    setFieldValue('agenda_id', null);
    setFieldValue('assignees', []);
    setFieldValue('children', []);
};



const durationOptions = [
    {name: '- none -', value: '0'},
    {name: '5 minutes', value: '5'},
    {name: '10 minutes', value: '10'},
    {name: '15 minutes', value: '15'},
    {name: '20 minutes', value: '20'},
    {name: '25 minutes', value: '25'},
    {name: '30 minutes', value: '30'},
    {name: '35 minutes', value: '35'},
    {name: '40 minutes', value: '40'},
    {name: '45 minutes', value: '45'},
    {name: '50 minutes', value: '50'},
    {name: '55 minutes', value: '55'},
    {name: '60 minutes', value: '60'},
];

// De/fine the initial default agenda structure
const defaultAgenda = [
    {id: '1', title: 'Welcome',
     children: [
         {id: '1.1', title: 'Call to Order'},
         {id: '1.2', title: 'Reading of the mission and vision'},
        ],
    },
    {id: '2', title: 'Changes to the Agenda'},
    {id: '3', title: 'Approval of Minutes'},
    {id: '4', title: 'Committee Reports',
     children: [
         {id: '4.1', title: 'Executive Director'},
         {id: '4.2', title: 'Finance'},
         {id: '4.3', title: 'Governance'},
         {id: '4.4', title: 'Marketing'},
         {id: '4.5', title: 'Fundraising'},
         {id: '4.6', title: 'Programs'},
        ],
    },
    {id: '5', title: 'Old Business'},
    {id: '6', title: 'New Business'},
    {id: '7', title: 'Comments, Announcements, and Other Business'},
    {id: '8', title: 'Next Meeting Date'},
    {id: '9', title: 'Adjournment'},
];

const DurationOptions = computed(() => {
    return durationOptions;
});

const getMeetingAgendas = () => {
    return useQuery({
        queryKey: ['getMeetingAgendasKey', meetingId],
        queryFn: async () => {
            const response = await useGetMeetingAgendasRequest(meetingId, {paginate: 'false'});
            return response.data;
        },
    });
};

const selectedUsers = () => {
    setFieldValue('assignees', selectedMembershipIds.value);
};
const removeselectedUsers = () => {
    setFieldValue('assignees', selectedMembershipIds.value);
};

const Memberships = computed(() => {
    const resul:  SelectedResult[] = [];
    if (allMemberships.value && allMemberships.value?.length > 0) {
        allMemberships.value.reduce((accumulator, currentMember) => {
            accumulator.push({
                id: currentMember.id,
                name: `${currentMember.user.full_name}`,
            });
            return accumulator;
        }, resul);
    }
    return resul;
});
const getmemberships = async () => {
    const response = await useGetMembershipsRequest(meetingId, boardId, {paginate: 'false'});
    allMemberships.value = response.data;
};


onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Agendas'}));
    getmemberships();
});




const {isLoading, data: Agendas, refetch: fetchMeetingAgendas} = getMeetingAgendas();
</script>

<template>
    <div class="flex gap-5">
        <div class="flex-1">
            <div class="card" style="min-height: 384px">
                <div class="card-body">
                    <div class="flex w-full">
                        <div class="flex-1">
                            <ol data-list_format="num_la_lr" class="agenda-list mb-0 border-l border-blue">
                                <li class="mb-2 hover:border-gray-400"
                                    v-for="(agenda, pIndex) in Agendas" :key="pIndex">
                                    <div class="rounded-lg border border-transparent hover:cursor-pointer
                                        border-blue -ml-7 p-2 pl-7 relative border-blue">
                                        <!-- <div class="absolute border -right-16 top-4 text-[10px] rounded
                                        text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200 px-2">
                                            10:30pm
                                        </div> -->
                                        <div class="flex gap-2 items-start" @click="enableEditing(pIndex, -1, agenda)">
                                            <div class="font-medium flex-1"> {{ formatAgendaEntry(pIndex)}}.{{ agenda.title }}
                                                <div class="text-sm text-gray-800 font-normal">
                                                    <p>{{ truncateDescription(agenda.description, 40) }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                                <div class="text-xs text-gray-600">
                                                    {{ formatDuration(agenda.duration) }}
                                                </div>
                                            </div>
                                            <div>
                                                <ul class="list-none" v-if="agenda.assignees">
                                                    <li class="text-sm text-primary"
                                                        v-for="assignee in agenda.assignees" :key="assignee">
                                                        {{assignee.user?.full_name  }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="ml-4 mt-2">
                                            <form novalidate
                                                  @submit.prevent="onSubmit"
                                                  v-if=" addingChild &&currentParentId === agenda.id" >
                                                <div class="flex gap-x-2">
                                                    <FormInput
                                                        :labeled = false
                                                        label="Agenda"
                                                        name="title"
                                                        class="form-control form-control-sm p-0"
                                                        placeholder="Enter Meeting Agenda"
                                                        type="text" />
                                                    <button type="submit" class="btn btn-primary h-10">
                                                        Save
                                                    </button>
                                                </div>
                                                <a @click.prevent="cancelEditing" class="text-xs cursor-pointer">
                                                    Cancel
                                                </a>
                                            </form>
                                        </div>
                                        <button v-if="editingParentIndex !== pIndex &&!addingChild"
                                                @click="enableAddingChild(pIndex, agenda.id)" class="ml-4 mt-2">
                                            + Add sub item
                                        </button>
                                    </div>
                                    <ol class="min-h-6 border-l border-blue">
                                        <li class="mb-2 hover:border-gray-400" draggable="false"
                                            v-for="(child, cIndex) in agenda.children" :key="cIndex">
                                            <div class="rounded-lg border border-transparent hover:cursor-pointer
                                            border-blue -ml-7 p-2 pl-7 relative
                                            border-blue">
                                                <div class="absolute border -right-16 top-4 text-[10px] rounded
                                                text-center py-0.5 text-gray-700 z-10
                                                 border-gray-200 bg-white px-1">
                                                    10:30pm
                                                </div>
                                                <div class="flex gap-2 items-start" @click="
                                                    enableEditing(pIndex,cIndex,child)">
                                                    <div class="font-medium flex-1">
                                                        {{ formatAgendaEntry(pIndex, cIndex) }}. {{ child.title }}
                                                        <div class="text-sm text-gray-800 font-normal">
                                                            <p>{{ child.description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1 h-6">
                                                        <div class="text-xs text-gray-600">
                                                            {{ formatDuration(child.duration)  }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <ul class="list-none" v-if="child.assignees">
                                                            <li class="text-sm text-primary"
                                                                v-for="childassignee in child.assignees"
                                                                :key="childassignee">
                                                                {{childassignee.user?.full_name  }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                            <div class="mt-4">
                                <div >
                                    <div v-if="isAddingNewParent" class="mt-4">
                                        <form novalidate @submit.prevent="onSubmit"  class="mt-4" >
                                            <div class="flex gap-x-2">
                                                <FormInput
                                                    :labeled = false
                                                    label="Agenda"
                                                    name="title"
                                                    class="form-control form-control-sm p-0"
                                                    placeholder="Enter Meeting Agenda"
                                                    type="text" />
                                                <button type="submit" class="btn btn-primary h-10">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                        <a @click.prevent="cancelEditing" class="text-xs cursor-pointer">
                                            Cancel
                                        </a>
                                    </div>
                                    <!-- <button class="btn btn-secondary block w-full">Add agenda item</button> -->
                                    <button @click="enableAddingNewParent" class="btn btn-secondary block w-full mb-4">
                                        Add Parent Item
                                    </button>
                                </div>
                            </div>
                            <div class="relative h-8">
                                <div class="absolute border -right-16 text-[10px] bottom-2 rounded
                                 text-center px-2 py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200">
                                    <div class="absolute left-0 right-0 text-green text-xxs bold -top-2.5">
                                        END
                                    </div>
                                    11:30pm
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="w-16 flex h-full justify-center py-4">
                                <div class="bg-gray-200 h-full relative left-1.5" style="width: 1px"> &nbsp; </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!---->
            </div>
        </div>
        <div :class="{    hidden: !is_editing,    'md:block': true,    'w-[350px]': true,}">
            <div class="w-[350px] relative">
                <div class="w-[350px]">
                    <div class="card mb-0">
                        <form novalidate @submit.prevent="onSubmit">
                            <div class="card-body">
                                <FormInput
                                    label="Agenda"
                                    name="title"
                                    class="w-full text-sm tracking-wide"
                                    placeholder="Enter Meeting Agenda" t
                                    ype="text" />
                                <FormTextBox
                                    label="Agenda Description"
                                    name="description"
                                    class=""
                                    placeholder="Enter Agenda  Description"
                                    :rows="2" />
                                <FormSelect name="duration"
                                            label="Duration"
                                            placeholder="Select Duration"
                                            :options="DurationOptions" />
                                <div class="form-group">
                                    <label
                                        class="text-xs uppercase font-medium text-gray-700 tracking-wide">
                                        People Responsible

                                    </label>
                                    <div :class="[
                                        'multiselect-container',
                                        { error: !!errorMessage },
                                    ]">
                                        <Multiselect
                                            id="assignees"
                                            v-model="selectedMembershipIds"
                                            mode="tags"
                                            placeholder="Choose your stack"
                                            :close-on-select="false"
                                            :filter-results="false"
                                            :min-chars="1"
                                            :resolve-on-load="false"
                                            :delay="0"
                                            :searchable="true"
                                            :options="Memberships"
                                            :valueProp="'id'"
                                            :trackBy="'id'"
                                            :label="'name'"
                                            :class="[
                                                'multiselect-container',
                                                { error: !!errorMessage },
                                            ]" @select="selectedUsers()" @deselect="removeselectedUsers()" />
                                        <div v-if="errorMessage" class="message"> {{ errorMessage }} </div>
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <button @click.prevent="cancelEditing" class="btn btn-link btn-sm text-danger h-7"> Delete </button>
                                    <div>
                                        <button @click.prevent="cancelEditing" class="btn btn-secondary btn-sm ml-1 mr-1"> Cancel </button>
                                        <button type="submit" class="btn btn-sm btn-primary ml-1 mr-1"> Save </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div :class="{ hidden: is_editing, 'md:block': true, 'w-[350px]': true }">
            <div class="w-[350px] relative">
                <div class="w-[350px]">
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <div class="text-center text-gray-700"> Select an agenda item to edit
                            <br role="presentation" data-uw-rm-sr="" />
                            <div class="text-xl mt-1"> <svg class="svg-inline--fa fa-turn-down-left" aria-hidden="true" focusable="false" data-prefix="far" data-icon="turn-down-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M6.5 271.6c-8.7 9.2-8.7 23.7 0 32.9l121.4 129c8.8 9.3 21 14.6 33.7 14.6c25.6 0 46.3-20.7 46.3-46.3l0-41.7 144 0c88.4 0 160-71.6 160-160l0-112c0-30.9-25.1-56-56-56l-32 0c-30.9 0-56 25.1-56 56l0 120c0 4.4-3.6 8-8 8l-152 0 0-41.7c0-25.6-20.7-46.3-46.3-46.3c-12.8 0-25 5.3-33.7 14.6L6.5 271.6zm153.5-93l0 61.5c0 13.3 10.7 24 24 24l176 0c30.9 0 56-25.1 56-56l0-120c0-4.4 3.6-8 8-8l32 0c4.4 0 8 3.6 8 8l0 112c0 61.9-50.1 112-112 112l-168 0c-13.3 0-24 10.7-24 24l0 61.5L57 288 160 178.5z"></path>
                            </svg> <!-- <i class="fa-regular fa-turn-down-left"></i> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
