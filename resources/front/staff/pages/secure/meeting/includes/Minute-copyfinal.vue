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
import {useGetMeetingAgendasRequest} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import {useCreateMinuteRequest, useCreateSubMinuteRequest, useGetMinutesRequest} from '@/common/api/requests/modules/minute/useMinuteRequest';
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
import {MinuteRequestPayload} from '@/common/parsers/minuteParser';



// Define the props the component expects
const props = defineProps({
    defaultMinutes: Boolean,
});

const route = useRoute();

const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const  defaultMinutes = props.defaultMinutes;


const minuteId = ref<string | null>(null);
const action = ref('create');
const addingChild = ref(false);
const allAgendas = ref<Agenda[]>([]);
const currentParentId = ref<string | null>(null);
const editingChildIndex = ref(-1);
const editingParentIndex = ref(-1);
const is_editing = ref(false);
const isAddingNewParent = ref(false);
const minutes = ref<Minute[]>([{text: ''}]);
const handleUnexpectedError = useUnexpectedErrorHandler();
// numbering the parent adn chiild
const parentOrder = 1 as number; // This would typically come from the parent minute's data
const childIndex = 2 as number; // Example child index, increment as needed



// meeting_id
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
    meeting_id: yup.mixed().required(),
    board_id: yup.string().nullable(),
    committee_id: yup.number().nullable(),
    membership_id: yup.string().nullable(),
    // // minutedetails
    minute_id: yup.string().nullable(),
    agenda_id: yup.string().required(),
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
    meeting_id: string;
    board_id: string | null;
    committee_id: string | null;
    membership_id: string | null;
    // // minutedetails
    minute_id: string | null;
    agenda_id: string;
    subagenda_id: string | null;
    description: string;
    status: string;

}>({
    validationSchema: minuteschema,
    initialValues: {
        meeting_id: meetingId,
        board_id: boardId,
        committee_id: null,
        membership_id: null,
        // // minutedetails
        minute_id: minuteId.value,
        agenda_id: '',
        subagenda_id: null,
        description: '',
        status: 'unpublished',
    },
});

const onSubmit = handleSubmit(async (values, {resetForm}) =>{
    try {
        const payload: MinuteRequestPayload = {
            meeting_id: values.meeting_id,
            board_id: values.meeting_id,
            committee_id: null,
            membership_id: null,
            // // minutedetails
            minute_id: minuteId.value? minuteId.value.toString() : null,
            agenda_id: values.agenda_id.toString(),
            subagenda_id: values.subagenda_id? values.subagenda_id.toString() : null,
            description: values.description,
            status: values.status,
        };
        if (action.value === 'create') {
            if(addingChild.value)
            {
                await useCreateSubMinuteRequest(payload, meetingId);
            }
            else if(isAddingNewParent.value)
            {
                await useCreateMinuteRequest(payload, meetingId);
            }
        }
        // else {
        //         console.log('3 useUpdateSubMinuteRequest', 'update child', editingChildIndex.value);
        //         const payload: MinuteRequestPayload = {
        //             title: values.title,
        //             _id: values._id,
        //             duration: values.duration,
        //             description: values.description,
        //             minute_id: null,
        //             assignees: [],
        //             children: [],
        //         };
        //         if(editingChildIndex.value !== -1){
        //             // update child
        //             console.log('useUpdateSubMinuteRequest', 'update child', editingChildIndex.value);
        //             payload.assignees = values.assignees;
        //             const minute_id = minuteId.value ? minuteId.value.toString() : null;
        //             payload.minute_id = minute_id,
        //             await useUpdateSubMinuteRequest(payload, meetingId);
        //         }
        //         else if(editingParentIndex.value !== -1){
        //             // update parent
        //             payload.assignees = values.assignees;
        //             const minute_id = minuteId.value ? minuteId.value.toString() : null;
        //             payload.minute_id = minute_id,
        //             await useUpdateMinuteRequest(payload, meetingId);
        //         }

        //         // if (selectedBoard.value?.id) {
        //         //     console.log('Selected Board ID:', selectedBoard.value.id);
        //         //     await useUpdateBoardRequest(
        //         //         payload,
        //         //         selectedBoard.value.id,
        //         //     );
        //         // }
        //     }
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
    editingChildIndex.value = -1;
    editingParentIndex.value = -1;
    is_editing.value = false;
    isAddingNewParent.value = false;
    setFieldValue('meeting_id', meetingId);
    setFieldValue('board_id', boardId);
    setFieldValue('committee_id', null);
    setFieldValue('membership_id', null);
    //minutedetails
    setFieldValue('minute_id', minuteId.value);
    setFieldValue('agenda_id', '');
    setFieldValue('subagenda_id', '');
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

const enableAddingChild = (pIndex, agenda:Agenda, child: Agenda) => {
    reset();
    addingChild.value = true;
    currentParentId.value = agenda.id; // Identify the parent
    editingParentIndex.value = pIndex; // Keep track of the parent being edited
    editingChildIndex.value = -1; // Reset child index since we're adding a new child
    // form.value.data.text = ''; // Clear the form for new input
    setFieldValue('agenda_id', agenda.id);
    setFieldValue('subagenda_id', child.id);
    is_editing.value = false; // Ensure we're not in editing mode
    action.value = 'create';
};

// edit functionality of minutes
const enableEditing = (pIndex: number, cIndex: number, agenda:Agenda, minute:Minute) => {
    reset();
    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;
    action.value = 'edit';

    // console.log('child', editingChildIndex.value !== -1, 'AGENDA', agenda.id, 'detailmnute', minute.id, 'subdetailminute', minute.subdetailminute);
    // console.log('PARENT',editingParentIndex.value !== -1, 'AGENDA', agenda.id, 'detailmnute', minute.id, minute.description);
    setFieldValue('agenda_id', agenda.id);
    if(editingChildIndex.value !== -1 && editingParentIndex.value !== -1 ){
        setFieldValue('description', minute.subdetailminute.description);
    }
    else if(editingParentIndex.value !== -1 && editingChildIndex.value === -1){
        setFieldValue('description', minute.description);
    }
};

interface Minute {
    text: string;
}

// Fetch minutes and initialize minuteId
const getMinutes = () => {
    return useQuery({
        queryKey: ['getMinutesKey', meetingId],
        queryFn: async () => {
            const response = await useGetMinutesRequest(meetingId, {paginate: 'false'});
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
    const response = await useGetMeetingAgendasRequest(meetingId, {paginate: 'false'});
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



const minuteDetails = computed(() => {
    const map: Record<string, DetailMinute[]> = {};

    // Ensure 'Minutes.value' has at least one item and that the first item has the 'detailminutes' property
    if (Minutes.value?.length > 0 && Minutes.value[0].detailminutes) {
        Minutes.value[0].detailminutes.forEach((detailminute) => {
            // Initialize the array in the map if it does not exist
            if (!map[detailminute.agenda_id]) {
                map[detailminute.agenda_id] = [];
            }
            map[detailminute.agenda_id].push(detailminute);
        });
    }
    return map;
});


</script>
<template>
    <div class="card h-full">
        <div class="card-header flex items-center">
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
        </div>
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
                                                <div class="font-medium flex-1" v-if="editingParentIndex === pIndex && editingChildIndex === -1 ||
                                                    isAddingNewParent && currentParentId === agenda.id && editingChildIndex === -1">
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
                                                    <div v-if="minuteDetails[agenda.id]" >
                                                        <div  v-for="(minutedetail, dIndex) in minuteDetails[agenda.id]" :key="dIndex"
                                                              @click="enableEditing(pIndex, -1, agenda, minutedetail)">
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
                                                    border-blue -ml-7 p-2 pl-7 relative
                                                    border-blue">
                                                    <div class="flex gap-2 items-start" >
                                                        <div class="font-medium flex-1"
                                                             v-if="editingParentIndex === pIndex && editingChildIndex === cIndex">
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
                                                        <div v-else class="font-medium flex-1">
                                                            <div v-if="minuteDetails[agenda.id] && minuteDetails[agenda.id][0] && minuteDetails[agenda.id][0].subdetailminute"
                                                                 @click="enableEditing(pIndex, cIndex, child, detail)">
                                                                <div class="font-bold text-primary" >
                                                                    {{formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex)) }}
                                                                </div>
                                                                <div class="font-medium text-danger">
                                                                    <p>{{minuteDetails[agenda.id][0].subdetailminute?.description}}</p>
                                                                </div>
                                                                <div class="font-medium" >
                                                                    <div class="badge bg-warning text-bold"> Click Here to Edit This SubAgenda Minute And Click save</div>
                                                                </div>
                                                                <!-- </div> -->
                                                            </div>
                                                            <!-- <div v-else> -->
                                                            <div  v-if="editingParentIndex !== pIndex && !addingChild" @click="enableAddingChild(pIndex, agenda, child)">
                                                                <div class="font-bold text-primary" >
                                                                    {{formatMinuteEntry(getNumbering(pIndex), child.title, undefined, undefined, undefined,  getNumbering(cIndex)) }} <br/>
                                                                </div>
                                                                <div class="font-medium" >
                                                                    <div class="badge bg-success text-bold"> Click Here to add Minutes for this SubAgenda and Click Save</div>
                                                                </div>
                                                            </div>
                                                            <!-- </div> -->
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
