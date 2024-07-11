<!-- eslint-disable max-len -->
<!-- eslint-disable vue/no-unused-vars -->
<!-- eslint-disable max-len -->
<!-- eslint-disable max-len -->
<!-- eslint-disable max-len -->
<!-- eslint-disable max-len -->
<!-- eslint-disable vue/return-in-computed-property -->
<script lang="ts" setup>
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed,defineProps,onMounted, Ref, ref, watch} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetMeetingScheduleAgendasRequest} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import {useCreateMinuteRequest, useCreateSubMinuteRequest, useGetMinutesRequest, useUpdateMinuteRequest, useUpdateSubMinuteRequest} from '@/common/api/requests/modules/minute/useMinuteRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formatMinuteEntry,
    getNumbering,
    truncateDescription,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Agenda} from '@/common/parsers/agendaParser';
import {DetailMinute} from '@/common/parsers/detailminuteParser';
import {Minute, MinuteRequestPayload} from '@/common/parsers/minuteParser';
import {SubdetailMinute} from '@/common/parsers/subdetailminuteParser';


const router = useRouter();
// Define the props the component expects
const props = defineProps({
    defaultMinutes: Boolean,
});
function goBack() {
    router.back();
}
const route = useRoute();

const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const  defaultMinutes = props.defaultMinutes;


const minuteId = ref<string | null>(null);
const action = ref('create');
const addingChild = ref(false);
const allAgendas = ref<Agenda[]>([]);
const currentParentId = ref<string | null>(null);
const childId = ref<string | null>(null);
const editingChildIndex = ref(-1);
const editingParentIndex = ref(-1);
const is_editing = ref(false);
const isAddingNewParent = ref(false);
const minutes = ref<Minute[]>([{text: ''}]);
const handleUnexpectedError = useUnexpectedErrorHandler();
// numbering the parent adn chiild
const parentOrder = 1 as number; // This would typically come from the parent minute's data
const childIndex = 2 as number; // Example child index, increment as needed



// schedule_id
// board_id
// committee_id
// membership_id
// status
// // minutedetails
// minute_id
// agenda_id
// description
// status
//oneagnda
const minuteschema = yup.object({
    schedule_id: yup.mixed().required(),
    board_id: yup.string().nullable(),
    committee_id: yup.number().nullable(),
    membership_id: yup.string().nullable(),
    // // minutedetails
    minute_id: yup.string().nullable(),
    agenda_id: yup.string().required(),
    detail_minute_id: yup.string().nullable(),
    subdetailminute_id: yup.string().nullable(),
    subagenda_id: yup.string().nullable(),
    description: yup.string().required(),
    status: yup.string().required(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    schedule_id: string;
    board_id: string | null;
    committee_id: string | null;
    membership_id: string | null;
    // // minutedetails
    minute_id: string | null;
    agenda_id: string;
    detail_minute_id: string | null;
    subdetailminute_id: string | null;
    subagenda_id: string | null;
    description: string;
    status: string;

}>({
    validationSchema: minuteschema,
    initialValues: {
        schedule_id: scheduleId,
        board_id: boardId,
        committee_id: null,
        membership_id: null,
        // // minutedetails
        minute_id: minuteId.value,
        agenda_id: '',
        detail_minute_id: null,
        subdetailminute_id: null,
        subagenda_id: null,
        description: '',
        status: 'unpublished',
    },
});

const onSubmit = handleSubmit(async (values, {resetForm}) =>{
    try {
        const payload: MinuteRequestPayload = {
            schedule_id: values.schedule_id,
            committee_id: null,
            membership_id: null,
            // // minutedetails
            minute_id: minuteId.value? minuteId.value.toString() : null,
            agenda_id: values.agenda_id.toString(),
            detail_minute_id: values.detail_minute_id? values.detail_minute_id.toString() : null,
            subdetailminute_id: values.subdetailminute_id? values.subdetailminute_id.toString() : null,
            subagenda_id: values.subagenda_id? values.subagenda_id.toString() : null,
            description: values.description,
            status: values.status,
        };
        if (action.value === 'create') {
            if(addingChild.value)
            {
                await useCreateSubMinuteRequest(payload, scheduleId);
            }
            else if(isAddingNewParent.value)
            {
                await useCreateMinuteRequest(payload, scheduleId);
            }
        }
        else {
            if(editingChildIndex.value !== -1){
                // update child
                await useUpdateSubMinuteRequest(payload, scheduleId);
                console.log('payload',payload);
                // {
                // "agenda_id": "9c475357-5bd0-4619-83d7-09938183e2d9",
                // "committee_id": null,
                // "description": "payload payload",
                // "detail_minute_id": "9c4753dc-4dc4-4539-9f58-d1bc339af9ff",
                // "membership_id": null,
                // "minute_id": "9c474fa2-b367-4487-a87d-6bc63bf00b71",
                // "schedule_id": "9c471064-45be-4f6a-a592-814149a835c2",
                // "status": "unpublished",
                // "subagenda_id": "9c475374-30ab-46f6-b4b5-4e7a7848b988",
                // "subdetailminute_id": "9c4782ec-3cf5-47fd-8f8e-e6fe3dfabb1c"
            // }
            // },
            // {
                // "agenda_id": "9c475357-5bd0-4619-83d7-09938183e2d9",
                // "committee_id": null,
                // "description": "srvqsoil",
                // "detail_minute_id": "9c4753dc-4dc4-4539-9f58-d1bc339af9ff",
                // "membership_id": null,
                // "minute_id": "9c474fa2-b367-4487-a87d-6bc63bf00b71",
                // "schedule_id": "9c471064-45be-4f6a-a592-814149a835c2",
                // "status": "unpublished",
                // "subagenda_id": "9c47535f-48aa-4c59-a7f0-9c3b23c25c4f",
                // "subdetailminute_id": "9c4783a4-b71b-44a4-9c3a-3a17719f2f1d"
            }
            else if(editingParentIndex.value !== -1){
                // update parent
                // await useUpdateMinuteRequest(payload, scheduleId);
            }
        }
        await fetchMinutes();
        reset();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});




const reset = ()=>{
    action.value = 'create';
    addingChild.value =false;
    currentParentId.value = null;
    childId.value = null;
    editingChildIndex.value = -1;
    editingParentIndex.value = -1;
    is_editing.value = false;
    isAddingNewParent.value = false;
    setFieldValue('schedule_id', scheduleId);
    setFieldValue('board_id', boardId);
    setFieldValue('committee_id', null);
    setFieldValue('membership_id', null);
    //minutedetails
    setFieldValue('minute_id', minuteId.value);
    setFieldValue('agenda_id', '');
    setFieldValue('detail_minute_id', null);
    setFieldValue('subdetailminute_id', null);
    setFieldValue('subagenda_id', null);
    setFieldValue('description','');
    setFieldValue('status', 'unpublished');
};
const enableAddingNewParent = (agenda:Agenda) => {
    reset();
    isAddingNewParent.value = true;
    currentParentId.value = agenda.id;
    is_editing.value = false;
    addingChild.value = false;
    editingParentIndex.value = -1;
    editingChildIndex.value = -1;
    action.value = 'create';
    setFieldValue('agenda_id', agenda.id);
};

const enableAddingChild = (pIndex, cIndex,  agenda:Agenda, child: Agenda) => {
    reset();
    addingChild.value = true;
    currentParentId.value = agenda.id; // Identify the parent
    editingParentIndex.value = pIndex; // Keep track of the parent being edited
    editingChildIndex.value = cIndex; // Reset child index since we're adding a new child
    // form.value.data.text = ''; // Clear the form for new input
    // addingChild && currentParentId === agenda.id && editingParentIndex === pIndex && action === 'create'
    setFieldValue('agenda_id', agenda.id);
    setFieldValue('subagenda_id', child.id);
    is_editing.value = false; // Ensure we're not in editing mode
    action.value = 'create';
    childId.value = child.id;
};

const isAddingChild = computed(() => {
    const result = addingChild.value && currentParentId.value === agenda.id && editingParentIndex.value === pIndex && editingChildIndex.value === cIndex && action.value === 'create';
    console.log('isAddingChild computed:', result);
    return result;
});

const isEditing = computed(() => {
    const result = is_editing.value && !isAddingNewParent.value && !addingChild.value && action.value === 'edit';
    console.log('isEditing computed:', result);
    return result;
});
// edit functionality of minutes
const enableEditing = (pIndex: number, cIndex: number, agenda:Agenda, detailminute:DetailMinute, subminute:SubdetailMinute) => {
    reset();
    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;
    action.value = 'edit';
    console.log('pIndex: number, cIndex:',pIndex, cIndex);
    console.log('States after enabling adding child:', {
        is_editing: is_editing.value,
        isAddingNewParent: isAddingNewParent.value,
        addingChild: addingChild.value,
        editingParentIndex: editingParentIndex.value,
        editingChildIndex: editingChildIndex.value,
        action: action.value,
    });
    // console.log('child', editingChildIndex.value !== -1, 'AGENDA', agenda.id, 'detailmnute', minute.id, 'subdetailminute', minute.subdetailminute);
    // console.log('PARENT',editingParentIndex.value !== -1, 'AGENDA', agenda.id, 'detailmnute', minute.id, minute.description);
    setFieldValue('agenda_id', agenda.id);
    
    if(editingChildIndex.value !== -1){
        setFieldValue('subdetailminute_id', subminute.id);
        setFieldValue('detail_minute_id', subminute.detail_minute_id);
        setFieldValue('subagenda_id', subminute.subagenda_id);
        setFieldValue('description', subminute.description);
    }
    else if(editingParentIndex.value !== -1){
        setFieldValue('detail_minute_id', detailminute.id);
        setFieldValue('description', detailminute.description);
    }
};

// Fetch minutes and initialize minuteId
const getMinutes = () => {
    return useQuery({
        queryKey: ['getMinutesKey', scheduleId],
        queryFn: async () => {
            const response = await useGetMinutesRequest(scheduleId, {paginate: 'false'});
            // Assuming response.data returns an array of minutes
            if (response.data.length > 0) {
                minuteId.value = response.data[0].id;  // Set minuteId from the first minute
            }
            return response.data;
        },
        onSuccess: (data) => {
            // Additional logic if needed when fetch is successful
        },
        onError: (error) => {
            console.error('Failed to fetch minutes:', error);
        },
    });
};

// const {data: minutes, refetch: fetchMinutes} = getMinutes();
const {isLoading, data: Minutes, refetch: fetchMinutes} = getMinutes();
const getmeetingagendas = async () => {
    const response = await useGetMeetingScheduleAgendasRequest(scheduleId, {paginate: 'false'});
    allAgendas.value = response.data;
};

const Agendas = computed(() => {
    if(props.defaultMinutes){
        return allAgendas.value;
    }
});

onMounted(async () => {
    // Initial fetch or other logic
    await fetchMinutes();
    if(props.defaultMinutes) {
        getmeetingagendas();
    }
});

// Watch for changes that might affect minuteId
watch(() => minutes.value, (newMinutes) => {
    // Update minuteId when minutes data changes
    if (newMinutes.length > 0) {
        minuteId.value = newMinutes[0];
    }
}, {deep: true});



// const minuteDetails = computed(() => {
//     const map: Record<string, DetailMinute[]> = {};

//     // Ensure 'Minutes.value' has at least one item and that the first item has the 'detailminutes' property
//     if (Minutes.value && Minutes.value?.length > 0 && Minutes.value[0].detailminutes) {
//         Minutes.value[0].detailminutes.forEach((detailminute,
//         ) => {
//             // Initialize the array in the map if it does not exist
//             if (!map[detailminute.agenda_id]) {
//                 map[detailminute.agenda_id] = [];
//             }
//             map[detailminute.agenda_id].push(detailminute);
//         });
//     }
//     return map;
// });

const minuteDetails = computed(() => {
    const map: Record<string, (DetailMinute | SubdetailMinute)[]> = {};

    if (Minutes.value && Minutes.value?.length > 0 && Minutes.value[0].detailminutes) {
        Minutes.value[0].detailminutes.forEach((detailminute) => {
            // Initialize the array in the map if it does not exist for detailminute
            if (!map[detailminute.agenda_id]) {
                map[detailminute.agenda_id] = [];
            }
            map[detailminute.agenda_id].push(detailminute);

            // Map subdetailminutes by subagenda_id
            detailminute.subdetailminutes.forEach((subdetailminute:SubdetailMinute) => {
                if (!map[subdetailminute.subagenda_id]) {
                    map[subdetailminute.subagenda_id] = [];
                }
                map[subdetailminute.subagenda_id].push(subdetailminute);
            });
        });
    }

    return map;
});

</script>
<template>
    <div class="card card-widget shadow-lg">
        <div class="card-footer" >
            <div class="d-flex align-items-center">
                <div class="ml-3 flex-1" >
                    <a href="" @click.prevent="goBack()"
                       class="text-blue-primary" >
                        <i class="fas fa-chevron-left"></i> Go back To Meeting
                    </a>
                </div>
                <div class="ml-auto flex self-end">
                    <button type="button" class="btn btn-sm mr-1 btn-success btn-lg">
                        <i class="fas fa-door-closed mr-1"></i> Close Meeting
                    </button>
                    <button v-if="Minutes?.length > 0 && Minutes[0].detailminutes" 
                            type="button" class="btn btn-sm mr-1 btn-danger btn-lg">
                        <i class="fa fa-trash mr-1"></i> Delete Minutes
                    </button>
                    <button type="button" class="btn btn-sm mr-1 btn-primary btn-lg">
                        <i class="fa fa-signature mr-1"></i> Get Signatures
                    </button>
                    <button type="button" class="btn btn-sm mr-1 btn-success btn-lg">
                        <i class="fa fa-check mr-1"></i> Publish Minutes
                    </button>                    
                </div>

            </div>
        </div>
    </div>
    <div class="card h-full">
        <!-- <div class="card-header flex items-center">
            <div class="flex items-center flex-1 w-full">
                <h2 class="card-header-title h3">
                    Meeting Minutes
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" @click.prevent="openCreateTaskModal" class="btn btn-tool">
                    <i class="far fa fa-plus mr-2"></i> Publish To be Viewed by others
                </button>
            </div>
        </div> -->
        <div id="MinutesEditor" class="container pt-12">
            <div class="codex-editor">
                <div class="codex-editor__redactor" style="padding-bottom: 300px;">
                    <div class="ce-block">
                        <div class="flex w-full">
                            <div class="flex-1" >
                                <ol data-list_format="num_la_lr" class="agenda-list mb-0 border-l border-blue" v-if="Agendas">
                                    <li class="mb-2 hover:border-gray-400" v-for="(agenda, pIndex) in Agendas" :key="pIndex">
                                        <div class="rounded-lg border border-transparent hover:cursor-pointer
                                                border-blue -ml-7 p-2 pl-7 relative border-blue">
                                            <div class="flex gap-2 items-start" >
                                                <div class="font-medium flex-1" v-if="editingParentIndex === pIndex && editingChildIndex === -1 && action === 'edit'||
                                                    isAddingNewParent && currentParentId === agenda.id && editingChildIndex === -1 && action === 'create'">
                                                    <div class="text-sm text-gray-800 font-normal">
                                                        <form novalidate @submit.prevent="onSubmit">
                                                            <div class="flex gap-x-2">
                                                                <FormTextBox
                                                                    :labeled="true"
                                                                    :label="`${ formatMinuteEntry(getNumbering(pIndex), agenda.title)}`"
                                                                    name="description"
                                                                    placeholder="Enter minute description and hit save"
                                                                    type="text"
                                                                    class="minute-input"
                                                                />
                                                                <button type="submit" class="btn btn-primary h-10 mt-12">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div v-else class="font-medium flex-1" >
                                                    <div  v-for="(minutedetail, dIndex) in minuteDetails[agenda.id]" :key="dIndex"
                                                          @click="enableEditing(pIndex, -1, agenda, minutedetail, undefined)">
                                                        <div class="font-bold text-primary" >
                                                            {{formatMinuteEntry(getNumbering(pIndex), agenda.title) }}
                                                        </div>
                                                        <div class="font-medium text-danger">
                                                            <p>{{minutedetail.description}}</p>
                                                        </div>
                                                        <div class="font-medium" >
                                                            <div class="badge bg-warning text-bold"> Click Here to Edit This Agenda Minute And Click save</div>
                                                        </div>
                                                    </div>
                                                    <div v-if="!minuteDetails[agenda.id]" @click="enableAddingNewParent(agenda)">
                                                        <div class="font-bold text-primary" >
                                                            {{formatMinuteEntry(getNumbering(pIndex), agenda.title) }}
                                                        </div>
                                                        <div class="font-medium" >
                                                            <div class="badge bg-info text-bold"> Click Here to add Minutes for this Agenda and Click Save</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ol class="min-h-6 border-l border-blue">
                                            <li class="mb-2 hover:border-gray-400" draggable="false"
                                                v-for="(child, cIndex) in agenda.children" :key="cIndex">
                                                <div class="rounded-lg border border-transparent hover:cursor-pointer
                                                    border-blue -ml-7 p-2 pl-7 relative border-blue">
                                                    <div class="flex gap-2 items-start" >
                                                        <div class="font-medium flex-1"
                                                             v-if="addingChild && currentParentId === agenda.id && editingParentIndex === pIndex && editingChildIndex === cIndex && action === 'create'
                                                                 || is_editing && !isAddingNewParent && !addingChild && editingParentIndex === pIndex && editingChildIndex === cIndex  && action === 'edit'">
                                                            <div class="text-sm text-gray-800 font-normal">
                                                                <form novalidate @submit.prevent="onSubmit">
                                                                    <div class="flex gap-x-2">
                                                                        <FormTextBox
                                                                            :labeled="true"
                                                                            :label="`${ formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex))}`"
                                                                            name="description"
                                                                            placeholder="Enter minute description and hit save"
                                                                            type="text"
                                                                            class="minute-input"
                                                                        />
                                                                        <button type="submit" class="btn btn-primary h-10 mt-12">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div  v-else class="font-medium flex-1" >
                                                            <div class="font-bold text-primary" >
                                                                {{formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex)) }}
                                                            </div>
                                                            <div  v-for="(minutedetail, dIndex) in minuteDetails[agenda.id]" :key="dIndex">
                                                                <div v-for="subminutedetail in minutedetail.subdetailminutes" :key="subminutedetail.key">                                                                     
                                                                    <div  v-if="subminutedetail.subagenda_id === child.id" @click="enableEditing(pIndex, cIndex, agenda, minutedetail, subminutedetail)">
                                                                        <div class="font-medium text-danger">
                                                                            <p>{{subminutedetail.description}}</p>
                                                                        </div>
                                                                        <div class="font-medium" >
                                                                            <div class="badge bg-warning text-bold"> Click Here to Edit This Agenda Minute And Click save</div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                                  
                                                            </div>                                                              
                                                            </div>
                                                            <div>
                                                                    <div v-if="editingParentIndex !== pIndex && !addingChild" @click="enableAddingChild(pIndex, cIndex, agenda, child)">
                                                                        <div class="font-medium" >
                                                                            <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Save</div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else-if="addingChild && currentParentId === agenda.id && editingParentIndex === pIndex && editingChildIndex === cIndex"></div>
                                                                    <div v-else>
                                                                        <div class="font-medium" @click="enableAddingChild(pIndex, cIndex, agenda, child)">
                                                                            <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Save</div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            <!-- <div v-for="(minutedetail, dIndex) in minuteDetails[agenda.id]" >
                                                                <div class="font-bold text-primary" >
                                                                    {{formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex)) }}
                                                                </div>
                                                                <div v-if="minutedetail.subdetailminutes && minutedetail.subdetailminutes.length">
                                                                    <div v-for="subminutedetail in minutedetail.subdetailminutes" :key="subminutedetail.key">                                                                    
                                                                        <div v-if="subminutedetail.subagenda_id === child.id" @click="enableEditing(pIndex, cIndex, agenda, minutedetail, subminutedetail)">
                                                                            <div class="font-medium text-black" >
                                                                                <p>{{subminutedetail.description}}</p>
                                                                            </div>
                                                                            <div class="font-medium" >
                                                                                <div class="badge bg-warning text-bold"> Click Here to Edit This SubAgenda Minute And Click save</div>
                                                                            </div>
                                                                        </div>                                                                   
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <div v-if="editingParentIndex !== pIndex && !addingChild" @click="enableAddingChild(pIndex, cIndex, agenda, child)">
                                                                        <div class="font-medium" >
                                                                            <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Save</div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else-if="addingChild && currentParentId === agenda.id && editingParentIndex === pIndex && editingChildIndex === cIndex"></div>
                                                                    <div v-else>
                                                                        <div class="font-medium" @click="enableAddingChild(pIndex, cIndex, agenda, child)">
                                                                            <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Save</div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div> -->
                                                            <div v-if="!minuteDetails[agenda.id]">
                                                                <div v-if="editingParentIndex !== pIndex && !addingChild" >
                                                                    <div  v-if="minuteDetails && minuteDetails[agenda.id] && minuteDetails[agenda.id].length > 0"  @click="enableAddingChild(pIndex, cIndex, agenda, child)">
                                                                        <div class="font-bold text-primary" >
                                                                            {{formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex)) }}
                                                                        </div>
                                                                        <div class="font-medium" >
                                                                            <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Savexx</div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else>
                                                                        <div class="font-medium" @click="enableAddingNewParent(agenda)">
                                                                            <div class="badge bg-warning text-bold"> Create Minute for main Agenda before Sub Agenda First</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div v-else-if="addingChild && currentParentId === agenda.id && editingParentIndex === pIndex && editingChildIndex === cIndex"></div>
                                                                <div v-else >
                                                                    <div  v-if="minuteDetails && minuteDetails[agenda.id] && minuteDetails[agenda.id].length > 0" @click="enableAddingChild(pIndex, cIndex, agenda, child)">
                                                                        <div class="font-bold text-primary" >
                                                                            {{formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex)) }}
                                                                        </div>
                                                                        <div class="font-medium" >
                                                                            <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Savevv</div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else>
                                                                        <div class="font-medium" @click="enableAddingNewParent(agenda)">
                                                                            <div class="badge bg-warning text-bold"> Create Minute for main Agenda before Sub Agenda First</div>
                                                                        </div>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



  <style scoped>
  .input-group {
    display: flex;
    align-items: center; /* Align items vertically in the center */
    gap: 10px; /* Optional: adds space between children */
    width: 100%; /* Ensure the group takes full width */
    margin: 10px 0; /* Vertical spacing between each group */
}

.add-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #333;
    padding: 5px 10px; /* Make button easier to click */
    margin-right: 10px; /* Space between button and input */
}

.minute-input, .form-input {
    flex-grow: 1; /* Makes the input take up the remaining space */
    padding: 8px;
    font-size: 16px;
}
  .meeting-minutes {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
  }

  .minutes-header {
    background-color: #f3f3f3;
    width: 100%;
    padding: 10px 20px;
    text-align: center;
  }

  .minutes-list ul {
    list-style: none;
    width: 100%;
    padding: 0;
  }

  .input-group {
    display: flex;
    align-items: center;
    margin: 10px;
  }

  .add-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #333;
  }

  .minute-input {
    flex: 1;
    padding: 8px;
    margin-left: 5px;
    font-size: 16px;
  }
  </style>
