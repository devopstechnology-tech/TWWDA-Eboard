<template>   
    <div class="card">
        <div class="card-header flex items-center h-auto p-4">
            <div class="flex items-center flex-1 w-full">
                <a href="" @click.prevent="goBack()"
                   class="mb-2 lg:mb-0 text-blue-primary card-header-title h3">
                    <i class="fas fa-chevron-left fa-xs"></i> Go back to The Meeting
                </a>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" @click.prevent="savePdf" :disabled="!pspdfStore.instance" class="btn btn-tool">
                    <i class="far fa fa-save mr-2 bg-primary"></i>
                    <span class="text-blue-primary font-bold">Save File</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div ref="containerRef" style="width: 100%; height: 450px;"></div>
        </div>
    </div>
</template>


<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import axios from 'axios';
import {useForm} from 'vee-validate';
import {nextTick, onMounted, onUnmounted, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetSignatureFileRequest, useUpdateSignatureFileRequest} from '@/common/api/requests/modules/signature/useSignatureFileRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formatDate, formatDateTime} from '@/common/customisation/Breadcrumb';
import {Attendance, SignatureFileData, SignatureRequestPayload} from '@/common/parsers/attendanceParser';
import useAuthStore from '@/common/stores/auth.store';
import {usePSPDFStore} from '@/common/stores/pspdfkit.store';

const route = useRoute();
const router = useRouter();
const userStore = useAuthStore();

const pdfUrl = ref<string>('');
const pspdfStore = usePSPDFStore();
const containerRef = ref(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const boardId = route.params.boardId as string;
const attendeeId = route.params.attendeeId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const mediaId = route.params.mediaId as string;
const fileName = ref<string>('');

const attendanceschema = yup.object({
    id: yup.string().required(),
    name: yup.string().required(),
    // location: yup.string().nullable(),
    // ip: yup.string().nullable(),
    signatureupload: yup.mixed().nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    id: string,
    name: string;
    signatureupload:File | string;
    // location:string;
    // ip:string;
}>({
    validationSchema: attendanceschema,
    initialValues: {
        id: attendeeId,
        name: '',
        // location:'',
        // ip:'',
        signatureupload:null,
    },
});

const savePdf = async () => {
    const file = await pspdfStore.savePdf(fileName.value);
    setFieldValue('signatureupload', file);
    setFieldValue('name', fileName.value);
    const locationData = await getCurrentLocation(); // Fetch the current IP address and location
    // await onSubmit(locationData); // Pass the location data to the onSubmit function
    await onSubmit(); // Pass the location data to the onSubmit function

};

const onSubmit = handleSubmit(async (values) => {
    try {
        const payload: SignatureRequestPayload = {
            id: values.id,
            name: values.name,
            signatureupload: values.signatureupload,
            // location: locationData.location, // Add the location to the payload
            // ip: locationData.ip, // Add the IP address to the payload
        };
        const response = await useUpdateSignatureFileRequest(payload, attendeeId, mediaId);
        await openFile(response.data);
    } catch (err) {
        pspdfStore.unloadPdf(containerRef.value);
        if (err instanceof yup.ValidationError) {
            setErrors(err.message);
        } else {
            handleUnexpectedError(err);
        }
    }
});

function updateMediaIdInURL(newMediaId) {
    const url = new URL(window.location);
    const pathSegments = url.pathname.split('/');
    pathSegments[pathSegments.length - 1] = newMediaId;
    url.pathname = pathSegments.join('/');
    window.history.pushState({path: url.toString()}, '', url.toString());
}


const goBack = () => {
    pspdfStore.unloadPdf(containerRef.value);
    router.push({
        name: 'BoardMeetingDetails',
        params: {
            boardId: boardId,
            meetingId: meetingId,
            scheduleId: scheduleId,
        },
    });
};



const populateFormFields = async (attendance:Attendance) => {
    if (!pspdfStore.instance) return;
    if(attendance.attendance_status ==='Absent'){
        const formFields = {
            meeting: attendance.schedule.meeting.title,
            schedule: formatDate(attendance?.schedule?.date),
            name: attendance?.membership?.user.full_name,
            date: formatDateTime(new Date()),
            position: attendance?.membership.position.name,
        };

        const formFieldValues = {};
        for (const [name, value] of Object.entries(formFields)) {
            formFieldValues[name] = value;
        }
        await pspdfStore.instance.setFormFieldValues(formFieldValues);
    }    
};

const openFile = (response: SignatureFileData) => {
    pspdfStore.unloadPdf(containerRef.value);
    if (response && response.file) {
        const base64 = response.file;
        const binaryString = window.atob(base64);
        const len = binaryString.length;
        const bytes = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            bytes[i] = binaryString.charCodeAt(i);
        }
        fileName.value = response.fileName;
        updateMediaIdInURL(response.mediaId);
        const pdfBlob = new Blob([bytes], {type: 'application/pdf'});
        pdfUrl.value = URL.createObjectURL(pdfBlob);
        pspdfStore.setPdfFile(pdfUrl.value);        
    }
};

const getSignatureFile = () => {
    return useQuery({
        queryKey: ['getFileKey'],
        queryFn: async () => {
            const response = await useGetSignatureFileRequest(attendeeId, mediaId);
            window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Document: ' + response.data.fileName}));
            await openFile(response.data);
            return response.data;
        },
    });
};
const getCurrentLocation = async (): Promise<{ ip: string, location: string }> => {
    try {
        const token = '4b60149b61646d';
        const response = await axios.get(`https://ipinfo.io?token=${token}`);
        const {ip, city, region, country} = response.data;
        const location = `${ip}, ${city}, ${region}, ${country}`;
        return {ip, location};
    } catch (error) {
        console.error('Error fetching IP address and location:', error);
        return {ip: 'Unknown IP', location: 'Unknown IP, Unknown City, Unknown Region, Unknown Country'};
    }
};
onMounted(async () => {
    await fetchSignatureFile();
});
onUnmounted(() => {
    pspdfStore.unloadPdf(containerRef.value);
});

const {isLoading, data: File, refetch: fetchSignatureFile} = getSignatureFile();
watch(
    () => pspdfStore.pdfFile,
    async () => {
        const appUrl = document.getElementById('app').dataset.appUrl;
        await pspdfStore.loadPdf(containerRef.value, appUrl);
        await nextTick();
        //enable if you area cutomising the form
        // if (!pspdfStore.instance) return;
        // await pspdfStore.instance.setToolbarItems((items) => [
        //     ...items,
        //     {type: 'form-creator'},
        // ]);
        // console.log('File', File.value?.attendance);
        if(File.value?.attendance){
            const att = File.value?.attendance;
            populateFormFields(att);
        }
    },
    {immediate: true},
);
</script>

<style scoped>
.signature-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
</style>
