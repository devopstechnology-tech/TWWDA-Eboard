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
    useApproveAlmanacRequest,
    useCancelledAlmanacRequest,
    useCreateAlmanacRequest,
    useDeleteAlmanacRequest,
    useExportAlmanacRequest,
    useGetAlmanacsRequest,
    useHeldAlmanacRequest,
    useImportAlmanacRequest,
    usePostponedAlmanacRequest,
    usePublishAlmanacRequest,
    usePublishMeetingRequest,
    useUpdateAlmanacRequest,
} from '@/common/api/requests/modules/almanac/useAlmanacRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import FormUpload from '@/common/components/FormUpload.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    coverChangeIcon,
    fileDetails,
    formatDate,
    formatFileSize,
    formatMoney,
    FormattedAgo,
    formatTime,
    getDayFromDate,
    getDuration,
    getMonthAbbreviation,
    getYearFromDate,
    resetfileDetails,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Almanac, AlmanacRequestPayload} from '@/common/parsers/almanacParser';

//constants
const showCreate = ref(false);
const action = ref('create');
const AlmanacModal = ref<HTMLDialogElement | null>(null);
const AlmanacImportModal = ref<HTMLDialogElement | null>(null);
const selectedAlmanac = ref<Almanac | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();
//inputs forms handling
//almanac
const schema = yup.object({
    type:yup.string().required(),
    purpose:yup.string().required(),
    start:yup.string().required(),
    end:yup.string().required(),
    budget:yup.string().required(),
    status:yup.string().required(),
    held:yup.string().required(),
    fileupload:yup.mixed().nullable(),
});
const {
    handleSubmit, setErrors, setFieldValue, values} = useForm<{
    type:string;
    purpose:string;
    start:string;
    end:string;
    budget:string;
    status:string;
    held:string;
    fileupload: File|null;

}>({
    validationSchema: schema,
    initialValues: {
        type:'',
        purpose:'',
        start:'',
        end:'',
        budget:'',
        status:'unapproved',
        held:'scheduled',
        fileupload:null,
    },
});

// modals
const openCreateAlmanacModal = () => {
    reseting();
    action.value = 'create';
    showCreate.value = true;
    AlmanacModal.value?.showModal();
};
const openImportAlmanacModal = () => {
    reseting(); 
    resetfileDetails();   
    action.value = 'import';
    showCreate.value = true;
    AlmanacImportModal.value?.showModal();
    setfakedata();
};
const openEditAlmanacModal = (e: Almanac) => {
    reseting(); 
    resetfileDetails();
    selectedAlmanac.value = e;
    // Set field values here
    setFieldValue('type', e.type);
    setFieldValue('purpose', e.purpose);
    setFieldValue('start', e.start);
    setFieldValue('end', e.end);
    setFieldValue('budget', e.budget);
    setFieldValue('status', e.status);    
    setFieldValue('held', e.held);    
    action.value = 'edit';
    showCreate.value = true;

    AlmanacModal.value?.showModal();
};
const reseting = () => {
    selectedAlmanac.value = null;
    setFieldValue('type', '');
    setFieldValue('purpose', '');
    setFieldValue('start', '');
    setFieldValue('end', '');
    setFieldValue('budget', '');
    setFieldValue('status', 'unapproved');
    setFieldValue('held', 'scheduled');
    setFieldValue('fileupload', null);
    resetfileDetails();
    action.value = 'create';
    showCreate.value = false;    
    AlmanacModal.value?.close();
    currentStatus.value = 'unapproved';
};
const DownloadAlmanacSample = async () => {   
    setfakedata();
    const data = {
        'type': 'sample',
        'document': 'csv',
        'title': 'almanacs-import-template.csv',
    };
    const res = await useExportAlmanacRequest(data);
    
    const blob = new Blob([res], {type: 'text/csv'});
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement('a');
    document.body.appendChild(a);
    a.href = url;
    a.download = data.title;  // Ensure the filename is taken from the response or as defined
    a.click();

    setTimeout(() => {
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }, 0);
};
//fill fake data so to use vee validatio: 
const setfakedata = async () =>{
    action.value = 'import';
    setFieldValue('type', '1');
    setFieldValue('purpose', '2');
    setFieldValue('start', '3');
    setFieldValue('end', '4');
    setFieldValue('budget', '6');
    setFieldValue('status', 'unapproved');
    setFieldValue('held', 'scheduled');
    console.log(values);
};

const onSubmit = handleSubmit(async (values) => {
    try {
        if (action.value === 'create') {
            await useCreateAlmanacRequest(values);
        } else if (action.value === 'import') {
            const payload: AlmanacRequestPayload = {
                type: values.type,
                purpose: values.purpose,
                start: values.start,
                end: values.end,
                budget: values.budget,
                status: values.status,
                held: values.held,
                fileupload:values.fileupload,
            };
            await useImportAlmanacRequest(payload);
        } else if (action.value === 'edit') {
            await useUpdateAlmanacRequest(values, selectedAlmanac.value?.id);
        } else {
            console.error('Invalid action specified');
        }
        await fetchAlmanacs();
        reseting();
        showCreate.value = false;
        AlmanacModal.value?.close();
        AlmanacImportModal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
        await fetchAlmanacs();
        reseting();
    }
});
// computed
// methods/functions

const getAlmanacs = () => {
    return useQuery({
        queryKey: ['getAlmanacsKey'],
        queryFn: async () => {
            const response = await useGetAlmanacsRequest({paginate: 'false'});
            return response.data;
        },
    });
};
//default loading
const {isLoading, data, refetch: fetchAlmanacs} = getAlmanacs();

// const currentStatus = ref('approved');

// const filteredAlmanacs = computed(() => {
//     if (!data.value || data.value.length === 0) {
//         return []; // Check if data is not loaded or empty
//     }
//     if (currentStatus.value === 'past') {
//         const now = new Date();
//         return data.value.filter(almanac => {
//             const almanacDate = new Date(almanac.start);
//             return almanacDate < now;
//         });
//     } else {
//         return data.value.filter(almanac => {
//             return almanac.status === currentStatus.value;
//         });
//     }
// });
const currentStatus = ref('scheduled');  // This can be dynamically updated

const filteredAlmanacs = computed(() => {
    if (!data.value || data.value.length === 0) return [];
   
    const now = new Date();
    return data.value.filter(almanac => {
        const start = new Date(almanac.start);
        const end = new Date(almanac.end);
        switch (currentStatus.value) {
            case 'past':
                return end < now;
            case 'ongoing':
                return start <= now && end >= now;
            case 'scheduled':
            case 'held':
            case 'postponed':
            case 'cancelled':
                
                return almanac.held === currentStatus.value;
            default:
                return almanac.status === currentStatus.value;
        }
    });
    // console.log('almanac.held', almanac.held);
});


const filterAlmanacs = (status: string) => {
    currentStatus.value = status;
};
const onApprovePublish = async (id: string) => {
    await useApproveAlmanacRequest(id);
    await fetchAlmanacs();
    currentStatus.value = 'approved';
};
const onHeld = async (id: string) => {
    await useHeldAlmanacRequest(id);
    await fetchAlmanacs();
    currentStatus.value = 'held';
};
const onCancelled = async (id: string) => {
    await useCancelledAlmanacRequest(id);
    await fetchAlmanacs();
    currentStatus.value = 'cancelled';
};
const onPostponed = async (id: string) => {
    await usePostponedAlmanacRequest(id);
    await fetchAlmanacs();
    currentStatus.value = 'postponed';
};
onMounted(async() => {
    await fetchAlmanacs();
});
</script>

<style scoped>
</style>
<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-widget">
                <div class="card-header">
                    <h1 class="h2 mb-2 lg:mb-0">Almanacs</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'approved' }"
                                @click="filterAlmanacs('approved')">
                            Approved
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'unapproved' }"
                                @click="filterAlmanacs('unapproved')">
                            UnApproved
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'ongoing' }"
                                @click="filterAlmanacs('ongoing')">
                            Ongoing
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'past' }"
                                @click="filterAlmanacs('past')">
                            Past
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'scheduled' }"
                                @click="filterAlmanacs('scheduled')">
                            Scheduled
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'held' }"
                                @click="filterAlmanacs('held')">
                            Held
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'postponed' }"
                                @click="filterAlmanacs('postponed')">
                            Postponed
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'cancelled' }"
                                @click="filterAlmanacs('cancelled')">
                            Cancelled
                        </button> 
                        <button type="button" @click.prevent="openImportAlmanacModal" 
                                class="mr-1 ml-1 btn btn-sm btn-primary">
                            Import
                        </button>
                        <button type="button" @click.prevent="openCreateAlmanacModal" class="btn btn-tool">
                            <i class="fas fa-plus mr-2"></i>
                        </button>
                    </div>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="products-list product-list-in-card pl-2 pr-2"  v-if="filteredAlmanacs.length > 0">
                        <li class="item" 
                            v-for="almanac in filteredAlmanacs" :key="almanac.id">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="calendar-icon w-full flex flex-col items-center 
                                        justify-center mt-1 calendaheight">
                                        <div class="month customonth">{{getMonthAbbreviation(almanac.start)}}</div>
                                        <div class="day font-medium customday">
                                            <span>{{getDayFromDate(almanac.start)}}</span>
                                        </div>
                                        <div class="year font-medium customyear">
                                            <span>{{getYearFromDate(almanac.start)}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="col-md-12 text-black ">                                        
                                        <h2 class="h2 mb-2 lg:mb-0 font-bold">{{ almanac.type }}</h2>
                                    </div>
                                    <div class="col-md-12 text-black font-medium">
                                        <p class=" text-primary font-bold">
                                            {{ almanac.purpose }}
                                        </p>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row border-top border-bottom border-warning 
                                d-flex justify-content-between align-items-center">
                                <div>
                                    Start: <span class="text-primary font-bold ml-2 mr-2">
                                        {{ formatDate(almanac.start) }}
                                    </span>
                                    ||
                                    End: <span class="text-primary font-bold ml-2 mr-2">
                                        {{ formatDate(almanac.end) }}
                                    </span>
                                    ||
                                    Duration: <span class="text-primary font-bold ml-2 mr-2">
                                        {{ getDuration(almanac.start,almanac.end, 'days') }}
                                    </span>
                                    ||
                                    When: <span class="text-primary font-bold ml-2 mr-2">
                                        {{ FormattedAgo(almanac.start,almanac.end, 'days') }}
                                    </span>
                                    ||
                                    Budget: <span class="text-primary font-bold ml-2 mr-2">
                                        {{ formatMoney(almanac.budget,"Kshs")  }}
                                    </span>
                                    ||
                                    Held Status: <span class="text-primary font-bold ml-2 mr-2">
                                        {{almanac.held  }}
                                    </span>
                                    ||
                                    Status: <span class="text-primary font-bold ml-2 mr-2">
                                        {{almanac.status  }}
                                    </span>
                                </div>
                                <span>
                                    <button class="btn btn-sm btn-primary font-bold ml-2 mr-2 mt-1 mb-1" 
                                            @click.prevent="openEditAlmanacModal(almanac)">
                                        Edit
                                    </button>
                                    <button v-if="currentStatus !== 'approved'" class="btn btn-sm btn-warning 
                                        font-bold ml-2 mr-2 mt-1 mb-1" 
                                            @click.prevent="onApprovePublish(almanac.id)">
                                        Approve
                                    </button>
                                    <button v-if="currentStatus !== 'held'" class="btn btn-sm btn-warning 
                                        font-bold ml-2 mr-2 mt-1 mb-1" 
                                            @click.prevent="onHeld(almanac.id)">
                                        Held
                                    </button>
                                    <button v-if="currentStatus !== 'cancelled'" class="btn btn-sm btn-warning 
                                        font-bold ml-2 mr-2 mt-1 mb-1" 
                                            @click.prevent="onCancelled(almanac.id)">
                                        Cancelled
                                    </button>
                                    <button v-if="currentStatus !== 'postponed'" class="btn btn-sm btn-warning 
                                        font-bold ml-2 mr-2 mt-1 mb-1" 
                                            @click.prevent="onPostponed(almanac.id)">
                                        Postponed
                                    </button>
                                </span>
                               
                            </div>

                        </li>
                    </ul>
                    <div v-else>
                        No almanacs found for {{ currentStatus }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center min-h-screen">
        <dialog id="almanacImportmodal" class="modal w-full max-w-4xl mx-auto p-0" ref="AlmanacImportModal">
            <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                <h3 class="font-bold text-lg text-center">
                    Meeting Spreadsheet Import & Export
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>

                <div class="overflow-auto p-4" style="max-height: 80vh;"> <!-- Scrollable Area -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Instructions Column -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-bold">Instructions for Preparing and Uploading CSV File</h3>
                            </div>
                            <div class="card-body">
                                <div class="font-bold text-primary mb-3">Download Template for Import</div>
                                <button @click.prevent="DownloadAlmanacSample" class="btn btn-primary btn-sm mb-3">
                                    Download CSV Template
                                </button>
                                <ul>
                                    <li>1. Open the downloaded CSV and review the format.</li>
                                    <li>2. Fill in your data as per the column headings, ensuring correct date formats.</li>
                                    <li>3. For meetings that were approve, the status place "approved" else use "unapproved" small caps.</li>
                                    <li>4. Delete the initial sample row from the file.</li>
                                    <li>5. Save your file in CSV format.</li>
                                    <li>6. Upload your file using the button below.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form novalidate @submit.prevent="onSubmit">
                                    <FormUpload
                                        :labeled="true"
                                        label="Upload Completed CSV File"
                                        name="fileupload"
                                        class="w-full text-sm text-white tracking-wide"
                                        placeholder="Select CSV file"
                                        type="file"
                                        accept=".csv, application/vnd.ms-excel, text/csv"
                                        @change="coverChangeIcon"
                                    />
                                    <div v-if="fileDetails && fileDetails.name" class="mt-3">
                                        <div class="mb-2">
                                            <img v-if="fileDetails.previewUrl"
                                                 :src="fileDetails.previewUrl"
                                                 alt="File Preview"
                                                 class="w-1/4 mb-2">
                                        </div>
                                        <p><strong>File Name: </strong> 
                                            <span> {{ fileDetails.name }}</span>
                                        </p>
                                        <p><strong>File Size: </strong> 
                                            <span> {{ formatFileSize(fileDetails.size) }}</span>
                                        </p>
                                        <p><strong>Type: </strong> 
                                            <span>{{ fileDetails.type }}</span>
                                        </p>
                                        <p><strong>Last Modified: </strong> 
                                            <span> {{ formatTime(fileDetails.lastModifiedDate) }}</span>
                                        </p>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-md mt-3 w-full">
                                        Upload CSV
                                    </button>
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
    <div class="flex justify-center items-center min-h-screen">
        <dialog id="almanacmodal" class="modal w-full max-w-4xl mx-auto p-0" ref="AlmanacModal">
            <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                <h3 class="font-bold text-lg text-center">
                    {{ action == 'create' ? 'Create Almanac' : 'Edit Almanac' }}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" >✕</button>
            
                <div class="overflow-auto p-4" style="max-height: 80vh;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-2">
                        <!-- Almanac form -->
                        <div class="col-span-2">
                            <form novalidate @submit.prevent="onSubmit" class="">
                                <div class="flex flex-wrap -mx-2">
                                    <div class="w-full md:w-1/2 px-1 md:px-2 mb-4">
                                        <FormInput
                                            :labeled="true"
                                            label="Meeting Type"
                                            name="type"
                                            placeholder="Enter Meeting Type"
                                            type="text"/>
                                    </div>
                                    <div class="w-full md:w-1/2 px-1 md:px-2 mb-4">
                                        <FormInput
                                            :labeled="true"
                                            label="Meeting Budget (KShs)"
                                            name="budget"
                                            placeholder="Enter Meeting Budget (KShs)"
                                            type="number"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-2">
                                    <div class="w-full md:w-1/2 px-2 mb-2">
                                        <FormDateTimeInput
                                            label="Meeting Start Day & Time"
                                            name="start"
                                            :flow="['month']"
                                            placeholder="Enter Meeting Start Day & Time"
                                        />
                                    </div>
                                    <div class="w-full md:w-1/2 px-2 mb-2">
                                        <FormDateTimeInput
                                            label="Meeting End Time"
                                            name="end"
                                            :flow="['month']"
                                            placeholder="Enter Meeting End Day & Time"
                                        />
                                    </div>
                                </div>
                                <FormTextBox
                                    :labeled="true"
                                    label="Meeting Purpose"
                                    name="purpose"
                                    placeholder="Enter Meeting Purpose"
                                    :rows="2"
                                />
                                <button type="submit" class="btn btn-primary btn-md w-full mt-6">
                                    {{ action == 'create' ? 'Create Almanac' : 'Edit Almanac' }}
                                </button>
                            </form>
                        </div>
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
.calendaheight{
    height: 100px!important;
    margin-bottom: 5px!important;
}
.customonth{
    margin-top: 10px !important;
    font-size: 17px !important;
    color: white !important;
    margin-bottom: 10px !important;
}
.customday{
    font-size: 24px!important;
}
.customyear{
    font-size: 19px!important;
}
</style>


useCancelledAlmanacRequest,
    useHeldAlmanacRequest,
    usePostponedAlmanacRequest,
    useCancelledAlmanacRequest,
    useHeldAlmanacRequest,
    usePostponedAlmanacRequest,
    
