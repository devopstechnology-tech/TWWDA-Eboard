<script lang="ts" setup>
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, defineProps, onMounted, Ref, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetMeetingScheduleAgendasRequest} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import {useCreateMinuteRequest, useCreateSubMinuteRequest, useDeleteMinutesRequest, useGetCEOApprovalRequest, useGetMinuteRequest, useGetMinutesRequest, useGetMinutesSignaturesRequest, useGetPublishMinutesRequest, useUpdateMinuteRequest, useUpdateSubMinuteRequest} from '@/common/api/requests/modules/minute/useMinuteRequest';
import {useGetCloseMeetingRequest} from '@/common/api/requests/modules/schedule/useScheduleRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formatDayDate,
    formatMinuteEntry,
    getDayOfWeek,
    getNumbering,
    loadLogo,
    truncateDescription,
} from '@/common/customisation/Breadcrumb';
import {formatDate, formattedDate} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Agenda} from '@/common/parsers/agendaParser';
import {DetailMinute} from '@/common/parsers/detailminuteParser';
import {Minute, MinuteRequestPayload} from '@/common/parsers/minuteParser';
import {SubdetailMinute} from '@/common/parsers/subdetailminuteParser';
import useAuthStore from '@/common/stores/auth.store';
import useSettingsStore from '@/common/stores/settings.store';


const router = useRouter();
// Define the props the component expects

function goBack() {
    router.back();
}
const route = useRoute();
const authStore = useAuthStore();
const settingsStore = useSettingsStore();

const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const minutesId = route.params.minutesId as string;


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

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        const payload: MinuteRequestPayload = {
            schedule_id: values.schedule_id,
            committee_id: null,
            membership_id: null,
            // // minutedetails
            minute_id: minuteId.value ? minuteId.value.toString() : null,
            agenda_id: values.agenda_id.toString(),
            detail_minute_id: values.detail_minute_id ? values.detail_minute_id.toString() : null,
            subdetailminute_id: values.subdetailminute_id ? values.subdetailminute_id.toString() : null,
            subagenda_id: values.subagenda_id ? values.subagenda_id.toString() : null,
            description: values.description,
            status: values.status,
        };
        if (action.value === 'create') {
            if (addingChild.value) {
                await useCreateSubMinuteRequest(payload, scheduleId);
            }
            else if (isAddingNewParent.value) {
                await useCreateMinuteRequest(payload, scheduleId);
            }
        }
        else {
            if (editingChildIndex.value !== -1) {
                // update child
                await useUpdateSubMinuteRequest(payload, scheduleId);
                console.log('payload', payload);
            }
            else if (editingParentIndex.value !== -1) {
                // update parent
                await useUpdateMinuteRequest(payload, scheduleId);
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




const reset = () => {
    action.value = 'create';
    addingChild.value = false;
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
    setFieldValue('description', '');
    setFieldValue('status', 'unpublished');
};
const enableAddingNewParent = (agenda: Agenda) => {
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

const enableAddingChild = (pIndex, cIndex, agenda: Agenda, child: Agenda) => {
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
const enableEditing = (pIndex: number, cIndex: number, agenda: Agenda, detailminute: DetailMinute, subminute: SubdetailMinute) => {
    reset();
    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;
    action.value = 'edit';
    console.log('pIndex: number, cIndex:', pIndex, cIndex);
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

    if (editingChildIndex.value !== -1) {
        setFieldValue('subdetailminute_id', subminute.id);
        setFieldValue('detail_minute_id', subminute.detail_minute_id);
        setFieldValue('subagenda_id', subminute.subagenda_id);
        setFieldValue('description', subminute.description);
    }
    else if (editingParentIndex.value !== -1) {
        setFieldValue('detail_minute_id', detailminute.id);
        setFieldValue('description', detailminute.description);
    }
};

// Fetch minutes and initialize minuteId
const getMinutes = () => {
    return useQuery({
        queryKey: ['getMinutesKey', scheduleId],
        queryFn: async () => {
            const response = await useGetMinuteRequest(scheduleId, {paginate: 'false'});
            minuteId.value = response.data.id;
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

const attendedAttendances = computed(() => {
    if (Minutes?.value?.attendances && Minutes?.value?.attendances?.length > 0) {
        return Minutes?.value?.attendances.filter(
            attendance => attendance.rsvp_status === 'Yes' && attendance.attendance_status === 'Attended') || [];
    }
    return [];

});

const presentOnEPlatformAttendances = computed(() => {
    if (Minutes?.value?.attendances && Minutes?.value?.attendances?.length > 0) {
        return Minutes?.value?.attendances.filter(
            attendance => attendance.rsvp_status === 'Online' && attendance.attendance_status === 'Attended') || [];
    }
    return [];
});

const absentWithApologyAttendances = computed(() => {
    if (Minutes?.value?.attendances && Minutes?.value?.attendances?.length > 0) {
        return Minutes?.value?.attendances.filter(
            attendance => ['Yes', 'No', 'Maybe'].includes(attendance.rsvp_status)
                && attendance.attendance_status === 'Absent') || [];
    }
    return [];
});

const absentAttendances = computed(() => {
    if (Minutes?.value?.attendances && Minutes?.value?.attendances?.length > 0) {
        return Minutes?.value?.attendances.filter(
            attendance => attendance.rsvp_status === 'Pending' && attendance.attendance_status === 'Absent') || [];
    }
    return [];
});

const getmeetingagendas = async () => {
    const response = await useGetMeetingScheduleAgendasRequest(scheduleId, {paginate: 'false'});
    allAgendas.value = response.data;
};

const Agendas = computed(() => {
    return allAgendas.value;
});

onMounted(async () => {
    // Initial fetch or other logic
    await fetchMinutes();
    getmeetingagendas();
});

// Watch for changes that might affect minuteId
watch(() => minutes?.value, (newMinutes) => {
    // Update minuteId when minutes data changes
    if (newMinutes) {
        minuteId.value = newMinutes;
    }
}, {deep: true});


const minuteDetails = computed(() => {
    const map: Record<string, (DetailMinute | SubdetailMinute)[]> = {};

    if (Minutes?.value && Minutes?.value.detailminutes) {
        Minutes?.value.detailminutes?.forEach((detailminute) => {
            // Initialize the array in the map if it does not exist for detailminute
            if (!map[detailminute.agenda_id]) {
                map[detailminute.agenda_id] = [];
            }
            map[detailminute.agenda_id].push(detailminute);

            // Map subdetailminutes by subagenda_id
            detailminute.subdetailminutes?.forEach((subdetailminute: SubdetailMinute) => {
                if (!map[subdetailminute.subagenda_id]) {
                    map[subdetailminute.subagenda_id] = [];
                }
                map[subdetailminute.subagenda_id].push(subdetailminute);
            });
        });
    }

    return map;
});
const companySettings = computed(() => {
    return settingsStore.getSettings();
});
const onAcceptCEOApproval = async (id: string) => {
    await useGetCEOApprovalRequest(id);
    await fetchMinutes();
};
</script>
<template>
    <div v-if="authStore.hasPermission(['view minutes'])">
        <div class="card card-widget shadow-lg" v-if="Minutes && Minutes?.approvalstatus === 'approved'">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="ml-3 flex-1">
                        <a href="" @click.prevent="goBack" class="text-blue-primary">
                            <i class="fas fa-chevron-left"></i> Go back To Meeting
                        </a>
                    </div>
                    <div class="ml-auto flex self-end" v-if="Minutes">
                        <button v-if="Minutes?.schedule?.closestatus === 'closed'" type="button"
                                class="btn btn-sm mr-1 btn-success btn-lg">
                            <i class="fas fa-door-closed mr-1"></i> Meeting Closed
                        </button>
                        <!-- <button v-else type="button" class="btn btn-sm mr-1 btn-success btn-lg"
                            @click.prevent="onCloseMeeting(Minutes?.schedule.id)">
                        <i class="fas fa-door-closed mr-1"></i> Close Meeting
                    </button> -->

                        <button v-if="Minutes?.approvalstatus === 'approved'" type="button"
                                class="btn btn-sm mr-1 btn-success btn-lg">
                            <i class="fa fa-check mr-1"></i> This Minutes Have been Approved
                        </button>
                        <button v-else type="button" class="btn btn-sm mr-1 btn-warning btn-lg"
                                @click.prevent="onAcceptCEOApproval(Minutes?.id)">
                            <i class="fa fa-check mr-1"></i> Sorry, The Minutes have not been Aprroved
                        </button>
                        <!-- <button v-if="Minutes?.detailminutes" 
                            type="button" class="btn btn-sm mr-1 btn-danger btn-lg"
                            @click.prevent="onDeleteMinutes(Minutes?.id)">
                        <i class="fa fa-trash mr-1"></i> Delete Minutes
                    </button>
                    <button type="button" class="btn btn-sm mr-1 btn-primary btn-lg"
                            @click.prevent="onGetMinutesSignatures(Minutes?.id)">
                        <i class="fa fa-signature mr-1"></i> Get Signatures
                    </button>
                    <button type="button" class="btn btn-sm mr-1 btn-success btn-lg"
                            @click.prevent="onGetPublishMinutes(Minutes?.id)">
                        <i class="fa fa-check mr-1"></i> Publish Minutes
                    </button>                     -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <span class="info-box-icon" style="left: 4%; margin-left: -45px; position: absolute; top: 88px;">
                    <div class="h3  text-bold font-bold uppercase text-primary"> Confidential</div>
                </span>
                <div class="text-center logo-container">
                    <img :src="loadLogo(companySettings?.logo)" alt="Organization Logo" class="img-fluid logo">
                </div>
                <div class="h3 text-center text-primary text-bold font-bold uppercase">{{ companySettings?.name }}</div>
                <hr class="thick-line">
                <h4 class="text-center text-primary text-bold uppercase h4 ">MINUTES OF THE {{ Minutes?.meeting?.title }}
                </h4>
                <p class="text-center text-primary text-bold uppercase h4">
                    HELD AT {{ Minutes?.meeting?.location }} ON
                    <!-- {{ getDayOfWeek(formatDayDate(Minutes?.schedule?.date)) }}  -->
                    {{ formatDate(Minutes?.schedule?.date) }}
                    STARTING AT {{ Minutes?.schedule?.start_time }}
                </p>
                <h5 class="mt-2 text-primary text-bold uppercase" v-if="attendedAttendances.length">Present</h5>
                <table class="table table-borderless" v-if="attendedAttendances.length">
                    <tbody>
                        <tr v-for="(attendance, index) in attendedAttendances" :key="attendance.id">
                            <td class="p-0">{{ index + 1 }}. {{ attendance.membership.user.full_name }}</td>
                            <td class="p-0 text-primary text-bold uppercase">
                                - {{ attendance.membership.position.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="mt-2 text-primary text-bold uppercase" v-if="presentOnEPlatformAttendances.length">Present on
                    E-platform
                </h5>
                <table class="table table-borderless" v-if="presentOnEPlatformAttendances.length">
                    <tbody>
                        <tr v-for="(attendance, index) in presentOnEPlatformAttendances" :key="attendance.id">
                            <td class="p-0">{{ index + 1 }}. {{ attendance.membership.user.full_name }}</td>
                            <td class="p-0 text-primary text-bold uppercase">
                                - {{ attendance.membership.position.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="mt-2 text-primary text-bold uppercase" v-if="absentWithApologyAttendances.length">Absent With
                    Apology
                </h5>
                <table class="table table-borderless" v-if="absentWithApologyAttendances.length">
                    <tbody>
                        <tr v-for="(attendance, index) in absentWithApologyAttendances" :key="attendance.id">
                            <td class="p-0">{{ index + 1 }}. {{ attendance.membership.user.full_name }}</td>
                            <td class="p-0 text-primary text-bold uppercase">
                                - {{ attendance.membership.position.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="mt-2 text-primary text-bold uppercase" v-if="absentAttendances.length">
                    Absent
                </h5>
                <table class="table table-borderless" v-if="absentAttendances.length">
                    <tbody>
                        <tr v-for="(attendance, index) in absentAttendances" :key="attendance.id">
                            <td class="p-0">{{ index + 1 }}. {{ attendance.membership.user.full_name }}</td>
                            <td class="p-0 text-primary text-bold uppercase">
                                - {{ attendance.membership.position.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <h5 class="mt-2">In Attendance</h5>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="p-0">1. Ms. Winfred Njoroge</td>
                        <td class="p-0">- Representative of Inspector General (State Corporations)</td>
                    </tr>
                    <tr>
                        <td class="p-0">2. Lilianne Kamau</td>
                        <td class="p-0">- Principal Legal Officer - Taking Notes</td>
                    </tr>
                    <tr>
                        <td class="p-0">3. CS. Josephine Muritu</td>
                        <td class="p-0">- Corporation Secretary/Manager Legal Services - Taking Notes</td>
                    </tr>
                </tbody>
            </table> -->
                <h5 class="mt-2 text-primary text-bold uppercase">Agenda</h5>
                <ul class="list-unstyled">
                    <template v-for="(item, index) in Agendas" :key="item.id">
                        <li>{{ index + 1 }}. {{ item.title }}</li>
                        <ul class="list-unstyled ml-4">
                            <li v-for="(child, childIndex) in item.children" :key="child.id">
                                {{ index + 1 }}.{{ childIndex + 1 }} {{ child.title }}
                            </li>
                        </ul>
                    </template>
                </ul>
                <div id="MinutesEditor" class="container">
                    <div class="codex-editor">
                        <div class="codex-editor__redactor" style="padding-bottom: 300px;">
                            <div class="ce-block">
                                <div class="flex w-full">
                                    <div class="flex-1">
                                        <ol data-list_format="num_la_lr" class="agenda-list mb-0 " v-if="Agendas">
                                            <li class="hover:border-gray-400" v-for="(agenda, pIndex) in Agendas"
                                                :key="pIndex">
                                                <div class="rounded-lg border border-transparent hover:cursor-pointer 
                                                    border-blue -ml-7 p-2 pl-7 relative border-blue">
                                                    <div class="flex gap-2 items-start">
                                                        <div class="font-medium flex-1">
                                                            <div v-for="(minutedetail, dIndex) in minuteDetails[agenda.id]"
                                                                 :key="dIndex"
                                                                 @click="enableEditing(pIndex, -1, agenda, minutedetail, undefined)">
                                                                <div class="font-bold text-primary">
                                                                    {{ formatMinuteEntry(getNumbering(pIndex),
                                                                                         agenda.title) }}
                                                                </div>
                                                                <div v-html="minutedetail.description"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ol class="min-h-6" v-if="agenda.children">
                                                    <li class="mb-2 hover:border-gray-400" draggable="false"
                                                        v-for="(child, cIndex) in agenda.children" :key="cIndex">
                                                        <div class="rounded-lg border border-transparent hover:cursor-pointer 
                                                            border-blue -ml-7 p-2 pl-7 relative border-blue">
                                                            <div class="flex gap-2 items-start">
                                                                <div class="font-medium flex-1">
                                                                    <div class="font-bold text-primary">
                                                                        {{ formatMinuteEntry(
                                                                            getNumbering(pIndex), child.title, undefined,
                                                                            undefined,
                                                                            undefined,
                                                                            getNumbering(cIndex)) }}
                                                                    </div>
                                                                    <div v-for="(minutedetail, dIndex) in minuteDetails[agenda.id]"
                                                                         :key="dIndex">
                                                                        <div v-for="subminutedetail in minuteDetails[child.id]"
                                                                             :key="subminutedetail.id">
                                                                            <div v-html="subminutedetail.description">
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
        </div>
        <div v-else class="card card-widget shadow-lg">
            <p class="m-0">
                <span class="h3  text-primary text-bold text-danger">Sorry, The Minutes have not been Aprroved</span>
            </p>
        </div>
    </div>
    <div v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>
</template>




<style scoped>
.input-group {
    display: flex;
    align-items: center;
    /* Align items vertically in the center */
    gap: 10px;
    /* Optional: adds space between children */
    width: 100%;
    /* Ensure the group takes full width */
    margin: 10px 0;
    /* Vertical spacing between each group */
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
    padding: 5px 10px;
    /* Make button easier to click */
    margin-right: 10px;
    /* Space between button and input */
}

.minute-input,
.form-input {
    flex-grow: 1;
    /* Makes the input take up the remaining space */
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

.thick-line {
    border-top: 5px solid #000;
}

.table-borderless td,
.table-borderless th {
    border: 0;
}

.table-borderless td {
    padding: 0.5rem;
}

.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo {
    max-width: 150px;
}

.content-wrapper {
    padding: 20px;
}
</style>
