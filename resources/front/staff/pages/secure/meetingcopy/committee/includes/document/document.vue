<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {nextTick,onMounted, onUnmounted, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetFileRequest, useUpdateFileRequest} from '@/common/api/requests/modules/file/useFileRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {FileData, FileRequestPayload} from '@/common/parsers/FileParser';
import {FolderRequestPayload} from '@/common/parsers/FolderParser';
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
const meetingId = route.params.meetingId as string;
const folderId = route.params.folderId as string;
const mediaId = route.params.mediaId as string;
const fileName = ref<string>('');


const goBack = () => {
    pspdfStore.unloadPdf(containerRef.value);
    router.back();  // This takes the user back to the previous page
    // router.push({
    //     name: 'BoardMeetingDetails',  // The name of the route to navigate to
    //     params: {
    //         boardId:boardId,
    //         meetingId:meetingId,
    //     },
    // });
};



watch(
    () => pspdfStore.pdfFile,
    async () => {
        const userName = userStore.user.first + ' ' + userStore.user.last;
        const appUrl = document.getElementById('app').dataset.appUrl;
        await pspdfStore.loadPdf(containerRef.value, appUrl);
        // Wait for the next DOM update cycle
        await nextTick();

        // Create a text annotation
        pspdfStore.createTextAnnotation(userName);

        // Create an ink annotation
        // Replace x1, y1, x2, y2 with the actual coordinates
        // pspdfStore.createInkAnnotation({x1: 10, y1: 20, x2: 30, y2: 40}, userName);
        // pspdfStore.createSignatureField(0, {left: 200, top: 300, width: 250, height: 150}, 'Signature Field 1');
        // pspdfStore.createSignatureField(1, {left: 100, top: 200, width: 200, height: 100}, 'Signature Field 2');
    },
    {immediate: true},
);

const openDocument = (event) => {
    // if (pspdfStore.pdfFile && pspdfStore.pdfFile.startsWith('blob:')) {
    //     window.URL.revokeObjectURL(pspdfStore.pdfFile);
    // }
    // pspdfStore.setPdfFile(window.URL.createObjectURL(event.target.files[0]));
    console.log(event.target.files[0]);
};

onUnmounted(() => {
    pspdfStore.unloadPdf(containerRef.value);
});
//  console.log('userStore', userName);


const folderschema = yup.object({
    name: yup.string().required(),
    meeting_id: yup.string().required(),
    folder_id: yup.string().nullable(),//editing
    parent_id: yup.string().nullable(),
    type:yup.string().oneOf(['folder', 'file']).required(),  // Ensure type is either 'folder' or 'file'
    fileupload:yup.mixed().nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    name: string;
    meeting_id: string,
    folder_id: string| null,
    parent_id: string | null,
    type:string,
    fileupload: File | string;

}>({
    validationSchema: folderschema,
    initialValues: {
        name: '',
        meeting_id: meetingId,
        folder_id: folderId,
        parent_id: '666',//given default though not being used during updates
        type:'file',
        fileupload:null,
    },
});
const savePdf = async () => {
    const file = await pspdfStore.savePdf(fileName.value);
    setFieldValue('fileupload', file);
    setFieldValue('name', fileName.value);
    console.log(file, values);
    await onSubmit();
};

const onSubmit = handleSubmit(async (values) => {
    try {
        const payload: FileRequestPayload = {
            folder_id: values.folder_id,
            name: values.name,
            type: values.type,
            fileupload: values.fileupload,
        };
        console.log('payload', payload);
        const response = await useUpdateFileRequest(payload, folderId, mediaId);
        await openFile(response.data);
        // await fetchMeetingFile();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const openFile=(response:FileData)=>{
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
function updateMediaIdInURL(newMediaId) {
    const url = new URL(window.location);
    const pathSegments = url.pathname.split('/');
    // Assuming the mediaId is the last segment of the path
    pathSegments[pathSegments.length - 1] = newMediaId;
    url.pathname = pathSegments.join('/');

    // Update the URL without navigation
    window.history.pushState({path: url.toString()}, '', url.toString());
}
const getMeetingFile = () => {
    return useQuery({
        queryKey: ['getFileKey'],
        queryFn: async () => {
            const response = await useGetFileRequest(folderId, mediaId);
            // console.log('response', response);
            window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Document: '+ response.data.fileName}));
            await openFile(response.data);
            return response;
        },
    });
};

onMounted(async () => {
    await fetchMeetingFile();
});

const {isLoading, data: File, refetch: fetchMeetingFile} = getMeetingFile();

</script>
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
            <div ref="containerRef" style="width: 100%; height: 100vh;"></div>
        </div>
    </div>
</template>


  <style scoped>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    text-align: center;
    color: #2c3e50;
  }

  body {
    margin: 0;
  }

  input[type="file"] {
      display: none;
  }

  .custom-file-upload {
      border: 1px solid #ccc;
      border-radius: 4px;
      display: inline-block;
      padding: 6px 12px;
      cursor: pointer;
      background:#4A8FED;
      padding:10px;
      color:#fff;
      font:inherit;
      font-size: 16px;
      font-weight: bold;
  }

  </style>

