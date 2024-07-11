<script lang="ts" setup>
import {useQuery} from '@tanstack/vue-query';
// import { getDocument, GlobalWorkerOptions } from 'pdfjs-dist/legacy/build/pdf';
// import 'pdfjs-dist/legacy/build/pdf.worker';
import {onMounted,onUnmounted, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import {useGetMeetingFileRequest} from '@/common/api/requests/modules/file/useFileRequest';
import {loadDefaultFileSvg,loadDefaultFolderSvg} from '@/common/customisation/Breadcrumb';

// Set the workerSrc to load PDF.js worker code, which is necessary for parsing PDF files
// GlobalWorkerOptions.workerSrc = 'pdfjs-dist/build/pdf.worker.js';

const route = useRoute();
const router = useRouter();

const goBack = () => {
    router.back();  // This takes the user back to the previous page
};
console.log('pspdfkitStore', pspdfkitStore);
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const folderId = route.params.folderId as string;
const mediaId = route.params.mediaId as string;

const pdfUrl = ref<string>('');

const getMeetingFile = () => {
    return useQuery({
        queryKey: ['getMeetingFileKey', meetingId],
        queryFn: async () => {
            const response = await useGetMeetingFileRequest(meetingId, mediaId, folderId);
            console.log('response', response);
            // if (response && response.data.file) {
            //     const base64 = response.data.file;
            //     const binaryString = window.atob(base64);
            //     const len = binaryString.length;
            //     const bytes = new Uint8Array(len);
            //     for (let i = 0; i < len; i++) {
            //         bytes[i] = binaryString.charCodeAt(i);
            //     }
            //     const pdfBlob = new Blob([bytes], {type: 'application/pdf'});
            //     pdfUrl.value = URL.createObjectURL(pdfBlob);
            // }
            return response;
        },
    });
};

// const {isLoading, data: File, refetch: fetchMeetingFile} = getMeetingFile();

onMounted(async () => {
    const {data: File} = await getMeetingFile();
    if (File && File.file) {
        const base64 = File.file;
        const binaryString = window.atob(base64);
        const len = binaryString.length;
        const bytes = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            bytes[i] = binaryString.charCodeAt(i);
        }
        const pdfBlob = new Blob([bytes], {type: 'application/pdf'});
        pdfUrl.value = URL.createObjectURL(pdfBlob);
        const instance = await loadPSPDFKit(pdfUrl.value);
        await createTextAnnotation(instance);
        await createInkAnnotation(instance, 5, 5, 100, 100);
    }
});

</script>
<template>
    <div class="card">
        <div class="card-header flex items-center h-auto p-4">
            <div class="flex items-center flex-1 w-full">
                <div class="block sm:flex w-full items-center">
                    <a href="" @click.prevent="goBack()"
                       class="mb-2 lg:mb-0 text-blue-primary">
                        <i class="fas fa-chevron-left fa-xs"></i> Go back to The Meeting
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h1>Details</h1>
            {{ pdfUrl }}
            <!-- {{ File }} -->
            <p>Board ID: {{ boardId }}</p>
            <p>Meeting ID: {{ meetingId }}</p>
            <p>Media ID: {{ mediaId }}</p>
            <div id="pspdfkit-container"></div>
        </div>
    </div>
</template>
<style scoped>
.pdf-container canvas {
  width: 100%;
  border: 1px solid #ccc;
}
</style>
