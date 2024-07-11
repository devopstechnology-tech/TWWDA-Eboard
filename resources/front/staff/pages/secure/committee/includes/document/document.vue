<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {nextTick, onMounted, onUnmounted, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetFileRequest, useUpdateFileRequest} from '@/common/api/requests/modules/file/useFileRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {FileData, FileRequestPayload} from '@/common/parsers/FileParser';
import useAuthStore from '@/common/stores/auth.store';
import {usePSPDFStore} from '@/common/stores/pspdfkit.store';
import {useSettingsStore} from '@/common/stores/settings.store';

const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();
const userStore = useAuthStore();
const settingsStore = useSettingsStore();

const pdfUrl = ref<string>('');
const pspdfStore = usePSPDFStore();
const containerRef = ref(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const committeeId = route.params.committeeId as string;
const folderId = route.params.folderId as string;
const mediaId = route.params.mediaId as string;
const fileName = ref<string>('');

const goBack = () => {
    pspdfStore.unloadPdf(containerRef.value);
    router.push({
        name: 'CommitteeDetails',
        params: {
            committeeId: committeeId,
        },
    });
};

watch(
    () => pspdfStore.pdfFile,
    async () => {
        const userName = `${userStore.user.first} ${userStore.user.last}`;
        const appUrl = document.getElementById('app').dataset.appUrl;
        const hasAnnotatePermission = authStore.hasPermission(['annotate documents']);

        await settingsStore.loadAndSaveSettings();
        await pspdfStore.loadPdf(containerRef.value, appUrl, hasAnnotatePermission);
        await nextTick();

        // if (hasAnnotatePermission) {
        //     if (pspdfStore.instance) {
        //         await pspdfStore.createTextAnnotation(userName);
        //     }
        // }
    },
    {immediate: true},
);

const openDocument = (event) => {
    console.log(event.target.files[0]);
};

onUnmounted(() => {
    pspdfStore.unloadPdf(containerRef.value);
});

const folderschema = yup.object({
    name: yup.string().required(),
    committee_id: yup.string().required(),
    folder_id: yup.string().nullable(),
    parent_id: yup.string().nullable(),
    type: yup.string().oneOf(['folder', 'file']).required(),
    fileupload: yup.mixed().nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    name: string;
    committee_id: string,
    folder_id: string | null,
    parent_id: string | null,
    type: string,
    fileupload: File | string;
}>({
    validationSchema: folderschema,
    initialValues: {
        name: '',
        committee_id: committeeId,
        folder_id: folderId,
        parent_id: '666',
        type: 'file',
        fileupload: null,
    },
});

const savePdf = async () => {
    const file = await pspdfStore.savePdf(fileName.value);
    setFieldValue('fileupload', file);
    setFieldValue('name', fileName.value);
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
    } catch (err) {
        pspdfStore.unloadPdf(containerRef.value);
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});

const openFile = (response: FileData) => {
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
        fileName.value = response.fileName;
        updateMediaIdInURL(response.mediaId);

        const pdfBlob = new Blob([bytes], {type: 'application/pdf'});
        pdfUrl.value = URL.createObjectURL(pdfBlob);
        pspdfStore.setPdfFile(pdfUrl.value);
    }
};

function updateMediaIdInURL(newMediaId) {
    const url = new URL(window.location);
    const pathSegments = url.pathname.split('/');
    pathSegments[pathSegments.length - 1] = newMediaId;
    url.pathname = pathSegments.join('/');

    window.history.pushState({path: url.toString()}, '', url.toString());
}

const getFile = () => {
    return useQuery({
        queryKey: ['getFileKey'],
        queryFn: async () => {
            const response = await useGetFileRequest(folderId, mediaId);
            window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Document: ' + response.data.fileName}));
            await openFile(response.data);
            return response;
        },
    });
};

onMounted(async () => {
    await fetchFile();
});

const {isLoading, data: File, refetch: fetchFile} = getFile();
</script>

<template>
    <div class="card">
        <div class="card-header flex items-center h-auto p-4">
            <div class="flex items-center flex-1 w-full">
                <a href="" @click.prevent="goBack()"
                   class="mb-2 lg:mb-0 text-blue-primary card-header-title h3">
                    <i class="fas fa-chevron-left fa-xs"></i> Go back to The Committee
                </a>
            </div>
            <div class="flex items-center space-x-2" v-if="authStore.hasPermission(['annotate documents'])">
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
    background: #4A8FED;
    padding: 10px;
    color: #fff;
    font: inherit;
    font-size: 16px;
    font-weight: bold;
}
</style>


