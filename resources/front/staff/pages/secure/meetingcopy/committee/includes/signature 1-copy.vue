<template>
    <div class="signature-container">
        <button @click="addSignatureAnnotation" class="btn btn-primary">Add Signature Annotation</button>
        <div ref="containerRef" style="width: 100%; height: 400px;"></div>
        <button @click="savePdf" class="btn btn-success">Save PDF</button>
    </div>
</template>
  
<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {nextTick, onMounted, onUnmounted, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import {useGetSignatureFileRequest, useUpdateSignatureFileRequest} from '@/common/api/requests/modules/signature/useSignatureFileRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {SignatureFIleData, SignatureRequestPayload} from '@/common/parsers/attendanceParser';
import useAuthStore from '@/common/stores/auth.store';
import {usePSPDFStore} from '@/common/stores/pspdfkit.store';
import * as yup from 'yup';
import { useForm } from 'vee-validate';
  
const route = useRoute();
const router = useRouter();
const userStore = useAuthStore();

const pdfUrl = ref<string>('');
const pspdfStore = usePSPDFStore();
const containerRef = ref(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const boardId = route.params.boardId as string;
const attendanceId = route.params.attendanceId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const attendeeId = route.params.attendeeId as string;
const mediaId    = route.params.mediaId as string;
// const mediaId = route.params.mediaId as string;
const fileName = ref<string>('');
  
const currentDate = new Date();
const formattedDate = currentDate.toLocaleString('en-US', {
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric',
    hour: 'numeric', 
    minute: 'numeric',
});
  
const userName = `${userStore.user.first} ${userStore.user.last}`;
const userPosition = 'Your Position'; // Replace with actual position
  


const goBack = () => {
    pspdfStore.unloadPdf(containerRef.value);
    // router.back();  // This takes the user back to the previous page
    router.push({
        name: 'BoardAttendanceDetails',  // The name of the route to navigate to
        params: {
            boardId:boardId,
            attendanceId:attendanceId,
        },
    });
};

watch(
    () => pspdfStore.pdfFile,
    async () => {
        // const userName = userStore.user.first + ' ' + userStore.user.last;
        const appUrl = document.getElementById('app').dataset.appUrl;
        await pspdfStore.loadPdf(containerRef.value, appUrl);
        // Wait for the next DOM update cycle
        await nextTick();

        // Create a text annotation
        // pspdfStore.createTextAnnotation(userName);

        // Create an ink annotation
        // Replace x1, y1, x2, y2 with the actual coordinates
        // pspdfStore.createInkAnnotation({x1: 10, y1: 20, x2: 30, y2: 40}, userName);
        // pspdfStore.createSignatureField(0, {left: 200, top: 300, width: 250, height: 150}, 'Signature Field 1');
        // pspdfStore.createSignatureField(1, {left: 100, top: 200, width: 200, height: 100}, 'Signature Field 2');
    },
    {immediate: true},
);




const addSignatureAnnotation = async () => {
    if (!pspdfStore.instance) return;
  
    const content = `Name: ${userName}\nPosition: ${userPosition}\nDate: ${formattedDate}\nSignature:`;
    await pspdfStore.createTextAnnotation(content, 0, {left: 50, top: 50, width: 300, height: 100});
  
    await pspdfStore.createSignatureField(0, {left: 50, top: 150, width: 200, height: 50}, 'signature');
  
    const file = await pspdfStore.savePdf('signed_document.pdf');
    console.log('Signature file created:', file);
    // Handle file upload or further processing here
};
  

const attendanceschema = yup.object({
    id: yup.string().required(),
    name: yup.string().required(),
    signatureupload:yup.mixed().nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    id: string,
    name: string;
    signatureupload: File | string;

}>({
    validationSchema: attendanceschema,
    initialValues: {
        id: attendanceId,
        name: '',
        signatureupload:'',
    },
});
const savePdf = async () => {
    const file = await pspdfStore.savePdf(fileName.value);
    setFieldValue('signatureupload', file);
    setFieldValue('name', fileName.value);
    console.log(file, values);
    await onSubmit();
};
const onSubmit = handleSubmit(async (values) => {
    try {
        const payload: SignatureRequestPayload = {
            id: values.id,
            id: values.id,
            signatureupload: values.signatureupload,
        };
        const response = await useUpdateSignatureFileRequest(payload, attendeeId);
        await openFile(response.data);
        // await fetchAttendanceFile();
    } catch (err) {
        if (err instanceof yup.ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
  
function updateMediaIdInURL(newMediaId) {
    const url = new URL(window.location);
    const pathSegments = url.pathname.split('/');
    // Assuming the mediaId is the last segment of the path
    pathSegments[pathSegments.length - 1] = newMediaId;
    url.pathname = pathSegments.join('/');

    // Update the URL without navigation
    window.history.pushState({path: url.toString()}, '', url.toString());
}
const openFile=(response:SignatureFIleData)=>{
    pspdfStore.unloadPdf(containerRef.value);
    if (response && response.file) {
        const base64 = response.file;
        console.log('base64base640', base64);
        const binaryString = window.atob(base64);
        const len = binaryString.length;
        const bytes = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            bytes[i] = binaryString.charCodeAt(i);
        }
        // Save file details
        fileName.value = response.fileName;
        // Update the mediaId in the URL
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
            // console.log('response', response);
            window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Document: '+ response.data.fileName}));
            await openFile(response.data);
            return response;
        },
    });
};

onMounted(async () => {
    await fetchSignatureFile();
});
onUnmounted(() => {
    pspdfStore.unloadPdf(containerRef.value);
});

const {isLoading, data: File, refetch: fetchSignatureFile} = getSignatureFile();

</script>
  
  <style scoped>
  .signature-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  </style>
  