<script setup lang="ts">
import {computed,reactive,ref} from 'vue';
import {loadDefaultFileSvg,loadDefaultFolderSvg} from '@/common/customisation/Breadcrumb';
const currentSort = ref('name-asc');
interface Document {
    id: string;
    name: string;
    type: 'folder' | 'file';
    children?: Document[];
    icon: string;
    date: string;
    time: string;
    visible?: boolean;
}

const documents = ref<Document[]>([
    {
        id: '1',
        name: 'Root Folder',
        type: 'folder',
        icon: 'folder.svg',
        date: 'Apr 20, 2024',
        time: '2:29 AM',
        visible: true,
        children: [
            {
                id: '3',
                name: 'Sub Folder 1',
                type: 'folder',
                icon: 'folder.svg',
                date: 'Apr 21, 2024',
                time: '3:30 PM',
                visible: false,
                children: [
                    {
                        id: '5',
                        name: 'File 1 in Sub Folder 1',
                        type: 'file',
                        icon: 'file.svg',
                        date: 'Apr 22, 2024',
                        time: '4:45 PM',
                        visible: true,
                    },
                    {
                        id: '6',
                        name: 'Sub Sub Folder 1',
                        type: 'folder',
                        icon: 'folder.svg',
                        date: 'Apr 23, 2024',
                        time: '5:00 PM',
                        visible: false,
                        children: [
                            {
                                id: '7',
                                name: 'File 1 in Sub Sub Folder 1',
                                type: 'file',
                                icon: 'file.svg',
                                date: 'Apr 24, 2024',
                                time: '6:15 PM',
                                visible: true,
                            },
                        ],
                    },
                ],
            },
            {
                id: '4',
                name: 'File 1 in Root Folder',
                type: 'file',
                icon: 'file.svg',
                date: 'Apr 21, 2024',
                time: '3:35 PM',
                visible: true,
            },
        ],
    },
    {
        id: '2',
        name: 'Root File',
        type: 'file',
        icon: 'file.svg',
        date: 'Apr 20, 2024',
        time: '2:35 AM',
        visible: true,
    },
]);

// Helper function to initialize visibility recursively
function initVisibility(docs: Document[], isVisible: boolean) {
    for (const doc of docs) {
        doc.visible = isVisible;
        if (doc.children && doc.children.length > 0) {
            initVisibility(doc.children, false); // Initially, all children are not visible
        }
    }
}


// Initialize the documents with proper visibility settings
initVisibility(documents.value, true); // Root level documents are visible
// Toggle visibility of a document and its children
function toggleVisibility(document: Document) {
    document.visible = !document.visible;
    if (document.children && document.visible) {
        // Make all direct children visible when a folder is opened
        initVisibility(document.children, true);
    } else if (document.children && !document.visible) {
        // Recursively hide all nested children
        initVisibility(document.children, false);
    }
}
// Sort options
const sortOptions = [
    {id: 'name-asc', name: 'Name (A-Z)'},
    {id: 'name-desc', name: 'Name (Z-A)'},
    {id: 'date-newest', name: 'Newest to oldest'},
    {id: 'date-oldest', name: 'Oldest to newest'},
];

const sortedDocuments = computed(() => {
    return [...documents.value].sort((a, b) => {
        switch (currentSort.value) {
            case 'name-asc':
                return a.name.localeCompare(b.name);
            case 'name-desc':
                return b.name.localeCompare(a.name);
            case 'date-newest':
                return new Date(b.date).getTime() - new Date(a.date).getTime();
            case 'date-oldest':
                return new Date(a.date).getTime() - new Date(b.date).getTime();
            default:
                return 0;
        }
    });
});
function applySort(option: string) {
    currentSort.value = option;
    // Implement sorting logic here
}
// Computed property to return the name of the current sort
const currentSortName = computed(() => {
    const option = sortOptions.find(option => option.id === currentSort.value);
    return option ? option.name : 'Unknown';  // Default to 'Unknown' if not found
});
</script>

<style scoped>
</style>
<template>
    <div class="card">
        <div class="card-header flex items-center h-auto p-4">
            <div class="flex items-center flex-1 w-full">
                <div class="block sm:flex w-full items-center">
                    <nav aria-label="Breadcrumbs" class="text-sm overflow-x-hdden mr-2 flex-1">
                        <ol class="breadcrumb hdden sm:flex mb-0 bg-warning">
                            <li class="breadcrumb-item whitespace-nowrap">
                                <a href="" class="text-gray-800 font-medium whitespace-nowrap">
                                    Documents
                                </a>
                            </li>
                            <li class="breadcrumb-item whitespace-nowrap">
                                <a href="" class="text-gray-800 font-medium whitespace-nowrap">
                                    jj
                                </a>
                            </li>
                            <li class="breadcrumb-item whitespace-nowrap">
                                <a href="" class="text-gray-800 font-medium whitespace-nowrap">
                                    anothe folder
                                </a>
                            </li>
                            <li class="breadcrumb-item whitespace-nowrap">
                                <a href="" class="text-gray-800 font-medium whitespace-nowrap">
                                    and another again
                                </a>
                            </li>
                        </ol>
                    </nav>
                    <div class="flex justify-between">
                        <div class="flex items-center mr-6">
                            <div class="dropdown">
                                <button class="nav-link dropdown-toggle btn whitespace-nowrap btn-secondary"
                                        href="#" id="navbarDropdown"
                                        type="button" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <span class="text-warning mr-1 ">sort by:</span>{{ currentSortName }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a v-for="option in sortOptions" :key="option.id"
                                       href="#" class="dropdown-item flex"
                                       @click.prevent="applySort(option.id)">
                                        {{ option.name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mr-6">
                            <div class="dropdown">
                                <button class="nav-link dropdown-toggle btn whitespace-nowrap btn-primary"
                                        href="#" id="navbarDropdown"
                                        type="button" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="far fa fa-plus mr-2"></i>
                                    New
                                </button>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="#" class="dropdown-item flex">
                                        <span class="w-5 block text-center mr-2">
                                            <i class="fas fa-folder-plus bg-primary"></i>
                                        </span>
                                        New folder
                                    </a>
                                    <a href="#" class="dropdown-item flex">
                                        <span class="w-5 block text-center mr-2">
                                            <i class="fas fa-file-upload bg-primary"></i>
                                        </span>
                                        <div class="flex-1">Upload a file</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-0 px-4 min-h-[300px] relative -top-px z-10">
            <table class="table mb-0">
                <tbody >
                    <RouterView />
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="pollmodal" class="modal" ref="PollModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{action == 'create' ? 'Create Meeting Poll' : 'Edit Meeting Poll'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    :labeled="true"
                                    label="Poll Question"
                                    name="question"
                                    class="col-span-3 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Poll Question"
                                    type="text"
                                />
                                <FormInput
                                    :labeled="true"
                                    label="Answer Option A"
                                    name="options[0].optiona.title"
                                    class="col-span-1 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Answer Option A"
                                    type="text"
                                />
                                <FormInput
                                    :labeled="true"
                                    label="Answer Option B"
                                    name="options[0].optionb.title"
                                    class="col-span-1 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Answer Option A"
                                    type="text"
                                />
                                <div :class="[
                                    'formdatetime-container',
                                    { error: !!errorMessage },
                                ]">

                                    <FormDateTimeInput
                                        label="Poll Due Date"
                                        name="duedate"
                                        :flow="['day']"
                                        placeholder="Poll Due Date"
                                    />
                                    <div v-if="errorMessage" class="message"> {{ errorMessage }} </div>
                                </div>
                                <FormTextBox
                                    label="Poll Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Poll Description"
                                    :rows="2"
                                />
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{action == 'create' ? 'Create Meeting Poll' : 'Edit Meeting Poll'}}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</template>
<style lang="scss">

</style>


