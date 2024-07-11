
<script lang="ts" setup>
import {notify} from '@kyvg/vue3-notification';
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, defineEmits,defineProps,inject,onMounted, ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {
    agendasSaveImportedMeetingScheduleAgendas,
    fetchlatestMeetingScheduleAgendas,
    useCreateAgendaRequest,
    useCreateSubAgendaRequest,
    useDeleteAgendaRequest,
    useDeleteSubAgendaRequest,
    useGetMeetingScheduleAgendasRequest,
    useUpdateAgendaRequest,
    useUpdateSubAgendaRequest,
} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import {useGetMeetingMembersRequest} from '@/common/api/requests/modules/meeting/useMeetingMemberRequest';
import {useGetMembershipsRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import {useGetMeetingScheduleRequest} from '@/common/api/requests/modules/schedule/useScheduleRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormQuillEditor from '@/common/components/FormQuillEditor.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formatAgendaEntry,        
    formatDuration,
    formatTime,
    resetCoverImage,
    resetIconImage, truncateDescription} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Agenda, AgendaRequestPayload} from '@/common/parsers/agendaParser';
import {
    CommitteeRequestPayload,
    SelectedResult,
} from '@/common/parsers/committeeParser';
import {Membership} from '@/common/parsers/membershipParser';
import {Schedule} from '@/common/parsers/scheduleParser';
import useAuthStore from '@/common/stores/auth.store';
import Multiselect from '@@/@vueform/multiselect';
const authStore = useAuthStore();
// v-if="authStore.hasPermission(['view meeting'])"

const emit = defineEmits(['change-tab']);
// Example function that emits an event
// const goToMembers = (tabId:string) => {
//     emit('change-tab', tabId);
// };
const fetchFunction = ref('default');

const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const action = ref('create');
const agendaction = ref('');
const actionitem = ref('');
const committeeId = route.params.committeeId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const importedAgendascheduleId = ref('');
const agendaId = ref<string | null>(null);
const selectedMembershipIds = ref<string[]>([]);
const allMemberships = ref<Membership[]>([]);
const schedule = ref<Schedule | null>(null);
const selectedAgenda = ref<Agenda | null>(null);
const saveagendasModal = ref<HTMLDialogElement | null>(null);//constants

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
    schedule_id: yup.mixed().required(),
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
    schedule_id: string;
    title: string;
    duration: number | null,
    description: string | null,
    agenda_id: string | null,
    assignees: string[],
    children: string[],

}>({
    validationSchema: agendaschema,
    initialValues: {
        schedule_id: scheduleId,
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

const enableEditing = (pIndex, cIndex, agenda:Agenda, item:string) => {
    selectedAgenda.value = agenda;
    agendaId.value = agenda.id;

    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;
    action.value = 'edit';
    actionitem.value = item;

    // defaultpopulation
    setFieldValue('title',  agenda.title);
    setFieldValue('schedule_id', scheduleId);
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
    try {
        if (action.value === 'create') {
            const payload: AgendaRequestPayload = {
                title: values.title,
                schedule_id: values.schedule_id,
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
                await useCreateSubAgendaRequest(payload, scheduleId);
            }
            else if(isAddingNewParent.value)
            {
                await useCreateAgendaRequest(payload, scheduleId);
            }
        } else {
            const payload: AgendaRequestPayload = {
                title: values.title,
                schedule_id: values.schedule_id,
                duration: values.duration,
                description: values.description,
                agenda_id: null,
                assignees: [],
                children: [],
            };
            if(editingChildIndex.value !== -1){
                payload.assignees = values.assignees;
                const agenda_id = agendaId.value ? agendaId.value.toString() : null;
                payload.agenda_id = agenda_id,
                await useUpdateSubAgendaRequest(payload, scheduleId);
            }
            else if(editingParentIndex.value !== -1){
                // update parent
                payload.assignees = values.assignees;
                const agenda_id = agendaId.value ? agendaId.value.toString() : null;
                payload.agenda_id = agenda_id,
                await useUpdateAgendaRequest(payload, scheduleId);
            }

            // if (selectedCommittee.value?.id) {
            //     console.log('Selected Committee ID:', selectedCommittee.value.id);
            //     await useUpdateCommitteeRequest(
            //         payload,
            //         selectedCommittee.value.id,
            //     );
            // }
        }
        await fetchMeetingScheduleAgendas();
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
    fetchFunction.value = 'default';
    agendaction.value = '';
    actionitem.value = '';
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


const DurationOptions = computed(() => {
    return durationOptions;
});


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

const deleteAgenda = async () =>{
    const id = selectedAgenda.value?.id as string;
    if(actionitem.value ==='agenda'){
        await useDeleteAgendaRequest(id);
    }else{
        await useDeleteSubAgendaRequest(id);
    }  
    await fetchMeetingScheduleAgendas();
    cancelEditing();
};

const startAgenda = async (val:string) => {     
    if(val ==='scratch'){
        agendaction.value = val;
    }else if(val ==='previous'){        
        fetchFunction.value = 'custom';
        agendaction.value = val;
        await fetchMeetingScheduleAgendas();
    }
};

const resetAgendaStartChoice = async () => { 
    if(agendaction.value ==='previous'){
        fetchFunction.value = 'default';
        await fetchMeetingScheduleAgendas();
    }
    agendaction.value = ''; 
};
const SaveImportedAgendas = async () => {
    const schedule_id = importedAgendascheduleId.value;    
    resetAgendaStartChoice();
    await agendasSaveImportedMeetingScheduleAgendas(schedule_id, scheduleId);
    saveagendasModal.value?.close();
    importedAgendascheduleId.value = '';  
    fetchFunction.value ='default'; 
    agendaction.value='';
    await fetchMeetingScheduleAgendas();
};

const getMeetingScheduleAgendas = () => {
    return useQuery({
        queryKey: ['getMeetingScheduleAgendasKey', scheduleId],
        queryFn: async () => {
            let response;
            if (fetchFunction.value === 'custom') {
                response = await fetchlatestMeetingScheduleAgendas({paginate: 'false'});
                if (response.data && response.data.length > 0) {
                    importedAgendascheduleId.value = response.data[0].schedule_id;
                    saveagendasModal.value?.showModal();
                } else {
                    notify({
                        title: 'Notice',
                        text: 'No agendas found in the database. Please create an agenda from scratch.',
                        type: 'warning',
                    });
                    fetchFunction.value = 'default';
                }
            } else if (fetchFunction.value === 'default') {
                response = await useGetMeetingScheduleAgendasRequest(scheduleId, {paginate: 'false'});
            }
            return response?.data || []; // Ensure that response.data is always an array
        },
    });
};

const {isLoading, data: Agendas, refetch: fetchMeetingScheduleAgendas} = getMeetingScheduleAgendas();

// Calculate total remaining time for agendas
const FetchedSchedule = computed(() => {
    return schedule.value;
});

const getmemberships = async () => {
    const response = await useGetMembershipsRequest(meetingId, {paginate: 'false'});
    allMemberships.value = response.data;
};

const handleManageMembersClick = () => {
    emit('change-tab', 'members');
};




onMounted(() => {
    getmemberships();
    window.addEventListener('refetchMemberships', getmemberships);
});
</script>

<template>
    <div v-if="agendaction === 'scratch' || agendaction === 'previous'"  class="card-header flex items-center">
        <div class="flex items-center flex-1 w-full">
        </div>
        <div class="flex items-center space-x-2">
            <button type="submit" @click.prevent="resetAgendaStartChoice" class="btn btn-tool">
                <span class="text-danger">Reset Agenda Start Choice</span>
            </button>
        </div>
    </div>
    <div v-if="agendaction === 'scratch' || 
             agendaction === 'previous' || 
             Agendas && Agendas.length" 
         class="flex gap-5">
        <div class="flex-1">
            <div class="card card-outline card-danger" style="min-height: 384px">
                <div class="card-body">
                    <div class="flex w-full">
                        <div class="flex-1">
                            <div class="relative h-8">
                                <div class="absolute border -right-16 text-[10px] bottom-2 rounded
                                 text-center px-2 py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200">
                                    <div class="absolute left-0 right-0 text-green text-xxs bold -top-2.5">
                                        Start
                                    </div>
                                    <!-- {{ FetchedSchedule?.start_time ? formatTime(FetchedSchedule.start_time) : '' }} -->
                                </div>
                            </div>
                            <ol data-list_format="num_la_lr" class="agenda-list mb-0 border-l border-blue">
                                <li class="mb-2 hover:border-gray-400"
                                    v-for="(agenda, pIndex) in Agendas" :key="pIndex">
                                    <div class="rounded-lg border border-transparent hover:cursor-pointer
                                        border-blue -ml-7 p-2 pl-7 relative border-blue">
                                        <div class="absolute border -right-16 top-4 text-[10px] rounded
                                        text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200 px-2">
                                            <!-- {{formatTime(FetchedSchedule?.start_time)}} -->
                                        </div>
                                        <div class="flex gap-2 items-start" 
                                             v-if="authStore.hasPermission(['edit agenda'])"
                                             @click="enableEditing(pIndex, -1, agenda, 'agenda')">
                                            <div class="font-medium flex-1">
                                                {{ formatAgendaEntry(pIndex)}}.{{ agenda.title }}
                                                <div class="text-sm text-gray-800 font-normal" 
                                                v-html="agenda.description">
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                                <div class="text-xs text-gray-600">
                                                    {{ formatDuration(agenda.duration) }}
                                                </div>
                                            </div>
                                            <div>
                                                <ul class="list-none assignees-list" v-if="agenda.assignees">
                                                    <li class="text-sm text-primary"
                                                        v-for="(assignee, idx) in agenda.assignees" :key="idx">
                                                        {{idx+1 }}. {{assignee.user?.full_name  }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div v-else class="flex gap-2 items-start">
                                            <div class="font-medium flex-1">
                                                {{ formatAgendaEntry(pIndex)}}.{{ agenda.title }}
                                                <div class="text-sm text-gray-800 font-normal"
                                                v-html="agenda.description">
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                                <div class="text-xs text-gray-600">
                                                    {{ formatDuration(agenda.duration) }}
                                                </div>
                                            </div>
                                            <div>
                                                <ul class="list-none assignees-list" v-if="agenda.assignees">
                                                    <li class="text-sm text-primary"
                                                        v-for="(assignee, idx) in agenda.assignees" :key="idx">
                                                        {{idx+1 }}. {{assignee.user?.full_name  }}
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
                                        <button v-if="editingParentIndex !== pIndex &&!addingChild 
                                                    && authStore.hasPermission(['create agenda'])"
                                                @click="enableAddingChild(pIndex, agenda.id)" class="ml-4 mt-2">
                                            + Add sub Agenda
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
                                                <div class="flex gap-2 items-start" 
                                                     v-if="authStore.hasPermission(['edit agenda'])"
                                                     @click="enableEditing(pIndex,cIndex,child, 'subagenda')">
                                                    <div class="font-medium flex-1">
                                                        {{ formatAgendaEntry(pIndex, cIndex) }}. {{ child.title }}
                                                        <div class="text-sm text-gray-800 font-normal"
                                                        v-html="child.description">
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1 h-6">
                                                        <div class="text-xs text-gray-600">
                                                            {{ formatDuration(child.duration)  }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <ul class="list-none assignees-list" v-if="child.assignees">
                                                            <li class="text-sm text-primary" 
                                                                v-for="(childassignee, idx) in child.assignees" 
                                                                :key="idx">
                                                                {{idx+1}}. {{ childassignee.user.full_name }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div v-else class="flex gap-2 items-start">
                                                    <div class="font-medium flex-1">
                                                        {{ formatAgendaEntry(pIndex, cIndex) }}. {{ child.title }}
                                                        <div class="text-sm text-gray-800 font-normal"
                                                             v-html="child.description">
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1 h-6">
                                                        <div class="text-xs text-gray-600">
                                                            {{ formatDuration(child.duration)  }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <ul class="list-none assignees-list" v-if="child.assignees">
                                                            <li class="text-sm text-primary" 
                                                                v-for="(childassignee, idx) in child.assignees" 
                                                                :key="idx">
                                                                {{idx+1}}. {{ childassignee.user.full_name }}
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
                                    <button v-if="authStore.hasPermission(['create agenda'])"
                                            @click="enableAddingNewParent" class="btn btn-secondary block w-full mb-4">
                                        Add Agenda
                                    </button>
                                </div>
                            </div>
                            <div class="relative h-8">
                                <div class="absolute border -right-16 text-[10px] bottom-2 rounded
                                 text-center px-2 py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200">
                                    <div class="absolute left-0 right-0 text-green text-xxs bold -top-2.5">
                                        END
                                    </div>
                                    {{ FetchedSchedule?.end_time ? formatTime(FetchedSchedule.end_time) : '' }}
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
        <div :class="{hidden: !is_editing,'md:block': true,'w-[350px]': true,}">
            <div class="w-[350px] relative">
                <div class="w-[350px]">
                    <div class="card card-outline card-danger mb-0">
                        <form novalidate @submit.prevent="onSubmit">
                            <div class="card-body">
                                <FormInput
                                    label="Agenda"
                                    name="title"
                                    class="w-full text-sm tracking-wide"
                                    placeholder="Enter Meeting Agenda" t
                                    ype="text" />
                                <FormQuillEditor
                                    label="Agenda Description"
                                    name="description"
                                    theme="snow"
                                    placeholder="Enter Agenda  Description"
                                    toolbar="minimal"
                                    contentType="html"
                                    
                                />
                                <FormSelect 
                                    name="duration"
                                    label="Duration"
                                    placeholder="Select Duration"
                                    :options="DurationOptions" 
                                />
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
                                    <button @click.prevent="handleManageMembersClick" class="btn btn-info mt-2">
                                        Manage Members
                                    </button>
                                </div>
                                <div class="flex justify-between">
                                    <button @click.prevent="deleteAgenda()" 
                                            class="btn btn-link btn-sm text-danger h-7"> Delete </button>
                                    <div>
                                        <button @click.prevent="cancelEditing"
                                                class="btn btn-secondary btn-sm ml-1 mr-1"> Cancel </button>
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
                <div class="w-[350px] card card-outline card-danger">
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <div class="text-center text-gray-700"> Select an agenda item to edit
                            <br role="presentation" data-uw-rm-sr="" />
                            <div class="text-xl mt-1"> 
                                <svg class="svg-inline--fa fa-turn-down-left" aria-hidden="true" focusable="false" data-prefix="far" data-icon="turn-down-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M6.5 271.6c-8.7 9.2-8.7 23.7 0 32.9l121.4 129c8.8 9.3 21 14.6 33.7 14.6c25.6 0 46.3-20.7 46.3-46.3l0-41.7 144 0c88.4 0 160-71.6 160-160l0-112c0-30.9-25.1-56-56-56l-32 0c-30.9 0-56 25.1-56 56l0 120c0 4.4-3.6 8-8 8l-152 0 0-41.7c0-25.6-20.7-46.3-46.3-46.3c-12.8 0-25 5.3-33.7 14.6L6.5 271.6zm153.5-93l0 61.5c0 13.3 10.7 24 24 24l176 0c30.9 0 56-25.1 56-56l0-120c0-4.4 3.6-8 8-8l32 0c4.4 0 8 3.6 8 8l0 112c0 61.9-50.1 112-112 112l-168 0c-13.3 0-24 10.7-24 24l0 61.5L57 288 160 178.5z"></path>
                                </svg> <!-- <i class="fa-regular fa-turn-down-left"></i> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="agendaction === ''" class="card card-outline card-danger">
        <div class="card-header text-center justify-center bg-gradient-info">
            <h3 class="text-center font-bold text-lg">
                Choose Your Starting Point
            </h3>
        </div>
        <div class="card-body">
            <div class="flex justify-center space-x-4 py-6">
                <a @click.prevent="startAgenda('scratch')"
                   class="btn btn-primary h-auto !p-0 p-0 mb-0 card flex-1">
                    <div class="text-center card-body">
                        <div class="flex items-center justify-center mx-auto mb-1 -mt-12
                                    bg-gradient-success rounded-full shadow w-11 h-11">
                            <i class="fa fa-list text-white"></i>
                        </div>
                        <h4 class="mb-0 text-gray-900">Start From Scratch</h4>
                    </div>
                </a>
                <!-- Start from the Agenda -->
                <a @click.prevent="startAgenda('previous')"
                   class="btn btn-primary h-auto !p-0 p-0 mb-0 card flex-1">
                    <div class="text-center card-body">
                        <div class="flex items-center justify-center mx-auto mb-1 -mt-12
                                    bg-gradient-warning rounded-full shadow w-11 h-11">
                            <i class="far fa-file text-white"></i>
                        </div>
                        <h4 class="mb-0 text-gray-900">Start From the Agenda</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="saveagendasModal" class="modal modal-primary" ref="saveagendasModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex text-white">
                    save the Imported AGendas from Previous Meeting
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form class="w-full rounded-xl mx-auto p-1 custom-modal">
                            <h3 class="text-center text-base font-bold text-primary">
                                Make use of the imported Agendas
                            </h3>
                            <div class="flex justify-center mt-4">
                                <button type="submit" 
                                        @click.prevent="SaveImportedAgendas" class="btn btn-lg btn-success">
                                    Save Imported Agendas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
    </div>


</template>

<style scoped>
.assignees-list {
    max-height: 100px; /* Adjust this height as needed */
    overflow-y: auto;
    padding-right: 5px; /* To prevent horizontal scrollbar if necessary */
}

.assignees-list::-webkit-scrollbar {
    width: 8px; /* Adjust the scrollbar width */
}

.assignees-list::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the scrollbar thumb color */
    border-radius: 4px; /* Round the scrollbar thumb edges */
}

.assignees-list::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Color when hovered */
}

.assignees-list::-webkit-scrollbar-track {
    background: #f1f1f1; /* Customize the scrollbar track color */
}
</style>
    


