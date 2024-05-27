<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref, watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {
  useCreateBoardFolderRequest,
  useCreateBoardUploadFolderRequest,
    // useCreateBoardFolderRequest,
    // useCreateBoardUploadFolderRequest,
    useGetBoardFoldersRequest, useUpdateBoardFolderRequest, useUpdateBoardUploadFolderRequest,
    // useUpdateBoardFolderRequest,
    // useUpdateBoardUploadFolderRequest,
} from '@/common/api/requests/modules/folder/useFolderRequest';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormUpload from '@/common/components/FormUpload.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formattedDateTime,
} from '@/common/customisation/Breadcrumb';
import {
    coverChangeIcon,
    fileDetails,
    formatDate,
    formatFileSize,
    formatTime,
    getFileExtensionByMimeType,
    loadDefaultFileSvg,
    loadDefaultFolderSvg,
    resetfileDetails,
    setfileDetails,
    supportedFileTypes,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Folder, FolderRequestPayload} from '@/common/parsers/FolderParser';

const handleUnexpectedError = useUnexpectedErrorHandler();

const route = useRoute();

const action = ref('create');
const type = ref('folder');
const currentSort = ref('name-asc');
const searchQuery = ref('');
const currentViewContext = ref([]);
const boardId = route.params.boardId as string;
const navigationPath = ref([{id: '1', name: 'Folders'}]); // Default path initialization
const selectedFolder = ref<Folder | null>(null);
const showCreate = ref(false);
const folderId = ref<string | null>(null);
const FolderModal = ref<HTMLDialogElement | null>(null);

// Sort options
const sortOptions = [
    {id: 'name-asc', name: 'Name (A-Z)'},
    {id: 'name-desc', name: 'Name (Z-A)'},
    {id: 'date-newest', name: 'Newest to oldest'},
    {id: 'date-oldest', name: 'Oldest to newest'},
];

// filtering sort
function applySort(option: string) {
    currentSort.value = option;
    // Implement sorting logic here
}
// Computed property to return the name of the current sort
const currentSortName = computed(() => {
    const option = sortOptions.find(option => option.id === currentSort.value);
    return option ? option.name : 'Unknown';  // Default to 'Unknown' if not found

});

//folder issues
// Adds a folder to the navigation path
function addToNavigationPath(folder: { id: any; name: any; }) {
    console.log('folder', folder);
    navigationPath.value.push({id: folder.id, name: folder.name});
}


function navigateTo(index: number) {
    // const crumb = navigationPath.value[index];
    // navigationPath.value = navigationPath.value.slice(0, index + 1);  // Trim the navigation path
    // const foundFolder = findFolderById(crumb.id, Folders);
    // currentViewContext.value = foundFolder.children || [];  // Reset the view context based on the breadcrumb
    const newPath = navigationPath.value.slice(0, index + 1);
    if (newPath.length !== navigationPath.value.length) {  // Only update if there's a real change in the path
        navigationPath.value = newPath;
        const folder = findFolderById(navigationPath.value.at(-1).id, Folders.value);
        currentViewContext.value = folder ? folder.children || [] : [];
    }
}

function findFolderById(folderId:string, docs: {
    name: string; id: string; type: string; parent_id: string|null; children: any[]|null; icon: string; created_at: string; }[]|undefined) {
    if (!Array.isArray(docs)) return null;  // Ensure docs is always an array

    for (const doc of docs) {
        if (doc.id === folderId) {
            return doc;
        } else if (doc.children && Array.isArray(doc.children)) {
            const found = findFolderById(folderId, doc.children);
            if (found) return found;
        }
    }
    return null;  // Return null if no folder is found
}

function openFolder(folder: { id: string; children: never[]; }) {
    if (navigationPath.value.at(-1).id !== folder.id) {  // Check if the last item is not the same as the clicked one
        addToNavigationPath(folder);
        console.log('folder', folder.children);
        currentViewContext.value = folder.children || [];  // Update context only if different folder clicked
    }
}
function countChildrenTypes(folder: Folder) {
    let folderCount = 0;
    let fileCount = 0;
    if (folder.children && folder.children.length > 0) {
        folder.children.forEach(child => {
            if (child.type === 'folder') {
                folderCount++;
            } else if (child.type === 'file') {
                fileCount++;
            }
        });
    }
    return {folderCount, fileCount};
}
// data

const getBoardFolders = () => {
    return useQuery({
        queryKey: ['getBoardFoldersKey', boardId],
        queryFn: async () => {
            const response = await useGetBoardFoldersRequest(boardId, {paginate: 'false'});
            return response.data;
        },
    });
};

const {isLoading, data: Folders, refetch: fetchBoardFolders} = getBoardFolders();

onMounted(async () => {
    await fetchBoardFolders();
});
//
// Additional watch for some other purpose
watch(Folders, (newFolders) => {
    if (newFolders && newFolders.length > 0) {
        if (navigationPath.value.length === 1) {
            const firstFolder = newFolders[0];
            navigationPath.value[0].id = '1';
            navigationPath.value[0].name = 'Documents';
        }
        // Update current view context if we are looking at the root or the first level
        if (navigationPath.value.length === 1) {
            currentViewContext.value = newFolders;
        } else {
            // Update the view context to reflect changes in the currently viewed folder
            const currentFolder = findFolderById(navigationPath.value.at(-1)?.id, newFolders);
            currentViewContext.value = currentFolder ? currentFolder.children || [] : [];
        }
    }
}, {immediate: true});

//for searching
const filteredFolders = computed(() => {
    if (!searchQuery.value) {
        return sortedFolders.value;  // Return all folders if there is no search query
    }
    return sortedFolders.value.filter(folder =>
        folder.name.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
});

const sortedFolders = computed(() => {
    const dataToSort = navigationPath.value.length > 1 ? currentViewContext.value : Folders.value;
    // Check if dataToSort is an array
    if (!Array.isArray(dataToSort)) {
        // If dataToSort is not an array, return an empty array or a default value
        return [];
    }
    return [...dataToSort].sort((a, b) => {
        switch (currentSort.value) {
            case 'name-asc':
                return a.name.localeCompare(b.name);
            case 'name-desc':
                return b.name.localeCompare(a.name);
            case 'date-newest':
                return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
            case 'date-oldest':
                return new Date(a.created_at).getTime() - new Date(b.created_at).getTime();
            default:
                return 0;
        }
    });
});

// forms
// folder
const folderschema = yup.object({
    name: yup.string().required(),
    meeting_id: yup.string().required(),
    board_id: yup.string().required(),
    folder_id: yup.string().nullable(),//editing
    parent_id: yup.string(),
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
    board_id: string,
    folder_id: string| null,
    parent_id: string,
    type:string,
    fileupload: File | string;

}>({
    validationSchema: folderschema,
    initialValues: {
        name: '',
        meeting_id: boardId,//just default though used
        board_id: boardId,
        folder_id: null,
        parent_id: '',
        type:'',
        fileupload:null,
    },
});
const updateName = (event: Event) =>{
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];

    setFieldValue('name', file.name);
    setFieldValue('type', 'file');

};
const openCreateFolderModal = (filetype) => {
    resetFolder();

    action.value = 'create';
    type.value = filetype;
    showCreate.value = true;
    FolderModal.value?.showModal();
    setFieldValue('type', filetype);
    // Determine the parent ID based on the navigation context
    const parent = navigationPath.value.at(-1);
    setFieldValue('parent_id', parent.id);
    console.log('parent', parent);
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        if (action.value === 'create') {
            if(type.value === 'folder'){
                const payload: FolderRequestPayload = {
                    children: [],
                    created_at: null,
                    icon: null,
                    id: null,
                    meeting_id: values.meeting_id,
                    board_id: values.board_id,
                    folder_id: null,
                    name: values.name,
                    parent_id: values.parent_id.toString(),
                    type: values.type,
                    fileupload:null,
                    media:[],
                };
                await useCreateBoardFolderRequest(payload, boardId);
            }else{
                const payload: FolderRequestPayload = {
                    children: [],
                    created_at: null,
                    icon: null,
                    id: null,
                    meeting_id: values.meeting_id,
                    board_id: values.board_id,
                    folder_id: null,
                    name: values.name,
                    parent_id: values.parent_id.toString(),
                    type: values.type,
                    fileupload:values.fileupload,
                    media:[],
                };
                await useCreateBoardUploadFolderRequest(payload, boardId);
            }
        } else {
            if(type.value === 'folder'){
                const payload: FolderRequestPayload = {
                    children: [],
                    created_at: null,
                    folder_id: null,
                    icon: null,
                    id: null,
                    meeting_id: values.meeting_id,
                    board_id: values.board_id,
                    name: values.name,
                    parent_id: values.parent_id.toString(),
                    type: values.type,
                    fileupload:null,
                    media:[],
                };
                const folder_id = folderId.value ? folderId.value.toString() : null;
                payload.folder_id = folder_id;
                await useUpdateBoardFolderRequest(payload, boardId, payload.folder_id);
            }else{
                const payload: FolderRequestPayload = {
                    children: [],
                    created_at: null,
                    folder_id: null,
                    icon: null,
                    id: null,
                    meeting_id: values.meeting_id,
                    board_id: values.board_id,
                    name: values.name,
                    parent_id: values.parent_id.toString(),
                    type: values.type,
                    fileupload:values.fileupload,
                    media:[],
                };
                const folder_id = folderId.value ? folderId.value.toString() : null;
                payload.folder_id = folder_id;
                await useUpdateBoardUploadFolderRequest(payload, boardId, payload.folder_id);
            }
        }
        await fetchBoardFolders();
        resetFolder();
        FolderModal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});

const openEditFolderModal = (folder:Folder, filetype:string) => {
    resetFolder();
    selectedFolder.value = folder;
    folderId.value = folder.id.toString();
    action.value = 'edit';
    type.value = filetype;
    showCreate.value = true;

    // Set field values here
    setFieldValue('name', folder.name);
    setFieldValue('folder_id', folder.id);
    setFieldValue('type', filetype);
    if(filetype === 'file'){
        setFieldValue('fileupload', folder.name);
        setfileDetails(folder.media[0]);
        setFieldValue('parent_id', folder.id);
    }else{
        setFieldValue('parent_id', folder.id);
    }
    console.log('folder.media', folder.name);

    FolderModal.value?.showModal();
};
const resetFolder = () => {
    setFieldValue('name', '');
    setFieldValue('folder_id', null);
    setFieldValue('fileupload', '');
    setFieldValue('parent_id', '');
    setFieldValue('type', '');
    // Reset navigation path to initial state
    type.value = 'folder';
    action.value = 'create';
    showCreate.value = false;
    selectedFolder.value = null;
    folderId.value = null;
    resetfileDetails();
};

</script>
<template>
    <div class="card">
        <div class="card-header p-3">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-12 mt-2">
                            <nav aria-label="Breadcrumbs" class="text-sm overflow-hidden">
                                <ol class="breadcrumb mb-0 bg-warning">
                                    <li v-for="(crumb, index) in navigationPath" :key="crumb.id" class="breadcrumb-item">
                                        <a href="#" class="text-gray-800 font-medium" @click.prevent="navigateTo(index)">
                                            {{ crumb.name }}
                                        </a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-3 col-md-4 col-12 ">
                            <div class="row">
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="dropdown">
                                        <button class="nav-link dropdown-toggle btn btn-secondary btn-block" href="#" id="navbarDropdown"
                                                type="button" role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <span class="text-warning mr-1">sort by:</span>{{ currentSortName }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a v-for="option in sortOptions" :key="option.id"
                                               href="#" class="dropdown-item"
                                               @click.prevent="applySort(option.id)">
                                                {{ option.name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="dropdown" v-if="navigationPath.length > 1">
                                        <button class="nav-link dropdown-toggle btn btn-primary btn-block" href="#" id="navbarDropdown"
                                                type="button" role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fas fa-plus mr-2"></i>
                                            New
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a href="#" @click.prevent="openCreateFolderModal('folder')"
                                               class="dropdown-item">
                                                <i class="fas fa-plus"></i> New folder
                                            </a>
                                            <a href="#" @click.prevent="openCreateFolderModal('file')"
                                               class="dropdown-item">
                                                <i class="fas fa-file-upload"></i> Upload a file
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="input-group input-group-lg">
                        <input type="search" class="form-control form-control-lg"
                               placeholder="Type your keywords here"
                               v-model="searchQuery">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body py-0 px-4 min-h-[300px] relative -top-px z-10">
            <div class="table-responsive">
                <table class="table mb-0">
                    <tbody>
                        <tr v-for="folder in filteredFolders" :key="folder.id"
                            class="group bg-white hover:bg-gray-100 cursor-pointer">
                            <td class="w-28">
                                <div v-if="folder.type==='folder'" @click.prevent="openFolder(folder)">
                                    <img v-if="folder.type === 'folder'" :src="loadDefaultFolderSvg(folder.icon)"
                                         class="img-fluid" alt="Folder Icon" />
                                </div>
                                <div v-else>
                                    <router-link :to="{
                                                     name: 'BoardMediaDetails',
                                                     params: {
                                                         boardId: boardId,
                                                         folderId: folder.id,
                                                         mediaId: folder?.media[0]?.uuid,
                                                     }
                                                 }"
                                                 class="d-block text-success hover:text-green-700 transition ease-in-out">
                                        <img :src="getFileExtensionByMimeType(folder?.media[0]?.mime_type)"
                                             class="img-fluid" alt="File Icon" />
                                    </router-link>
                                </div>
                            </td>
                            <td>
                                <div v-if="folder.type === 'folder'">
                                    <p class="font-weight-bold text-primary text-truncate">
                                        {{ folder.name }}
                                    </p>
                                    <p class="text-sm font-weight-bold text-primary">
                                        {{ countChildrenTypes(folder).folderCount }}:
                                        <span class="text-black">Folders</span>
                                    </p>
                                    <p class="text-sm font-weight-bold text-primary">
                                        {{ countChildrenTypes(folder).fileCount }}:
                                        <span class="text-black">Files</span>
                                    </p>
                                </div>
                                <div v-else>
                                    <p class="font-weight-bold text-primary text-truncate">
                                        {{ folder?.media[0]?.file_name }}
                                    </p>
                                    <p class="text-sm font-weight-bold text-primary">
                                        Size: <span class="text-black">{{ formatFileSize(folder?.media[0]?.size) }}</span>
                                    </p>
                                </div>
                            </td>
                            <td class="w-28">
                                <p class="font-weight-bold text-primary text-truncate">
                                    {{ formatDate(folder.created_at) }}
                                </p>
                                <p class="text-xs text-primary">
                                    {{ formatTime(folder.created_at) }}
                                </p>
                            </td>
                            <td class="w-20 text-center">
                                <div class="flex justify-end space-x-2">
                                    <a href="#" v-if="folder.type === 'folder'"
                                        @click.prevent="openEditFolderModal(folder, 'folder')"
                                       class="text-warning hover:text-blue-700 transition ease-in-out">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#" v-else
                                        @click.prevent="openEditFolderModal(folder, 'file')"
                                       class="text-warning hover:text-blue-700 transition ease-in-out">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <router-link v-if="folder.type === 'file'"  :to="{
                                                     name: 'BoardMediaDetails',
                                                     params: {
                                                         boardId: boardId,
                                                         folderId: folder.id,
                                                         mediaId: folder?.media[0]?.uuid,
                                                     }
                                                 }"
                                                 class="text-success hover:text-green-700 transition ease-in-out">
                                        <i class="far fa-eye"></i>
                                    </router-link>
                                    <a href="#" @click.prevent="remove(folder.id)"
                                       class="text-danger hover:text-blue-700 transition ease-in-out">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="foldermodal" class="modal" ref="FolderModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{ action === 'create' ? (type === 'folder' ? 'Create Folder' :
                        'Upload File') : (type === 'folder' ? 'Update Folder' : 'Update File') }}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1 custom-modal">
                            <div  class="row">
                                <FormInput
                                    :labeled="true"
                                    :label="type === 'folder'? 'Folder name' : 'Upload File name'"
                                    name="name"
                                    class="col-md-12 w-full text-sm  text-white tracking-wide"
                                    :placeholder="type === 'folder'? 'Folder name' : 'Upload File name'"
                                    type="text"
                                />
                                <div v-if="type === 'file'" class="row mt-2 ml-2">
                                    <FormUpload
                                        :labeled="true"
                                        label="Upload Cover Image for the Board"
                                        name="fileupload"
                                        class="w-full text-sm  text-white tracking-wide col-md-12"
                                        placeholder="Enter Cover Image of the Board"
                                        type="file"
                                        :accept="supportedFileTypes.join(', ')"
                                        @change="coverChangeIcon($event); updateName($event)"
                                    />
                                    <div v-if="values.fileupload" class="row mt-2 ml-2">
                                        <div class="col-md-6">
                                            <img v-if="fileDetails.previewUrl"
                                                 :src="fileDetails.previewUrl"
                                                 alt="File Preview" class="file_attachment"/>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>File Name:</strong>
                                                <span class="text-bold text-primary">
                                                    {{ fileDetails.name }}
                                                </span>
                                            </p>
                                            <p><strong>File Size:</strong>
                                                <span class="text-bold text-primary">
                                                    {{formatFileSize(fileDetails.size)}}
                                                </span>
                                            </p>
                                            <p><strong>Type:</strong>
                                                <span class="text-bold text-primary">
                                                    {{ fileDetails.type }}
                                                </span>
                                            </p>
                                            <p><strong>Last Modified:
                                               </strong>
                                                <span class="text-bold text-primary">
                                                    {{formatTime(fileDetails.lastModifiedDate)}}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-md mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{ action === 'create' ? (type === 'folder' ? 'Create Folder' :
                                    'Upload File') : (type === 'folder' ? 'Update Folder' : 'Update File') }}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</template>
<style scoped>
.upload-container {
  display: flex;
  align-items: center;
  gap: 20px;
}

.icon-preview img {
  width: 50px;
  height: auto;
}
</style>



