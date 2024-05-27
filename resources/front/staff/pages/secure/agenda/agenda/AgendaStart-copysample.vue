<template>
    <div class="flex gap-5">
        <div class="flex-1">
            <div class="card" style="min-height: 384px">
                <div class="card-body">
                    <div class="flex w-full">
                        <div class="flex-1">
                            <ol data-list_format="num_la_lr" class="agenda-list mb-0">
                                <li
                                    class="mb-2 hover:border-gray-400 border-l border-blue"
                                    v-for="(item, pIndex) in items"
                                    :key="pIndex"
                                >
                                    <div
                                        class="rounded-lg border border-transparent hover:cursor-pointer border-blue -ml-7 p-2 pl-7 relative border-blue"
                                    >
                                        <div
                                            class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200 px-2"
                                        >
                                            10:30pm
                                        </div>
                                        <div
                                            v-if="
                                                editingParentIndex === pIndex &&
                                                    editingChildIndex === -1 &&
                                                    !addingChild
                                            "
                                        >
                                            <div class="flex gap-x-2">
                                                <input
                                                    type="text"
                                                    v-model="form.data.text"
                                                    class="form-control form-control-sm"
                                                    placeholder="Edit parent item text"
                                                    @keyup.enter="submit"
                                                />
                                                <button @click="submit" class="btn btn-primary h-10">Save</button>
                                            </div>
                                            <a @click.prevent="cancelEditing" class="text-xs cursor-pointer">Cancel</a>
                                        </div>
                                        <div class="flex gap-2 items-start" v-else @click="enableEditing(pIndex, -1)">
                                            <div class="font-medium flex-1">
                                                {{ item.text }}
                                                <div class="text-sm text-gray-800 font-normal">
                                                    <p>decsritpion</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                                <div class="text-xs text-gray-600">15 minutes</div>
                                            </div>
                                            <div>
                                                <ul class="list-none">
                                                    <li class="text-sm text-gray-800">User Allocated</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ol class="min-h-6">
                                        <li
                                            class="mb-2 hover:border-gray-400 border-l border-blue"
                                            draggable="false"
                                            v-for="(child, cIndex) in item.children"
                                            :key="cIndex"
                                        >
                                            <div
                                                class="rounded-lg border border-transparent hover:cursor-pointer border-blue -ml-7 p-2 pl-7 relative border-blue"
                                            >
                                                <div
                                                    class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-white px-1"
                                                >
                                                    10:30pm
                                                </div>
                                                <div
                                                    v-if="editingParentIndex === pIndex && editingChildIndex === cIndex"
                                                >
                                                    <div class="flex gap-x-2">
                                                        <input
                                                            type="text"
                                                            v-model="form.data.text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Edit sub item text"
                                                            @keyup.enter="submit"
                                                        />
                                                        <button @click="submit" class="btn btn-primary h-10">
                                                            Save
                                                        </button>
                                                    </div>
                                                    <a @click.prevent="cancelEditing" class="text-xs cursor-pointer"
                                                    >Cancel</a
                                                    >
                                                </div>
                                                <div
                                                    class="flex gap-2 items-start"
                                                    v-else
                                                    @click="enableEditing(pIndex, cIndex)"
                                                >
                                                    <div class="font-medium flex-1">
                                                        {{ child.text }}
                                                        <div class="text-sm text-gray-800 font-normal">
                                                            <p>Description</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1 h-6">
                                                        <div class="text-xs text-gray-600">10 minutes</div>
                                                    </div>
                                                    <div>
                                                        <ul class="list-none">
                                                            <li class="text-sm text-gray-800">Assignee</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div
                                                    v-if="addingChild && currentParentId === item.id"
                                                    class="ml-4 mt-2"
                                                >
                                                    <div class="flex gap-x-2">
                                                        <input
                                                            type="text"
                                                            v-model="form.data.text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Enter sub item text"
                                                            @keyup.enter="submit"
                                                        />
                                                        <button @click="submit" class="btn btn-primary h-10">
                                                            Save
                                                        </button>
                                                    </div>
                                                    <a @click.prevent="cancelEditing" class="text-xs cursor-pointer"
                                                    >Cancel</a
                                                    >
                                                </div>
                                                <button
                                                    v-if="editingParentIndex !== pIndex && !addingChild"
                                                    @click="enableAddingChild(pIndex)"
                                                    class="ml-4 mt-2"
                                                >
                                                    + Add sub item
                                                </button>
                                            </div>
                                        </li>
                                    </ol>
                                    <div v-if="isAddingNewParent" class="mt-4">
                                        <div class="flex gap-x-2">
                                            <input
                                                type="text"
                                                v-model="form.data.text"
                                                class="form-control form-control-sm"
                                                placeholder="Enter parent item text"
                                                @keyup.enter="submit"
                                            />
                                            <button @click="submit" class="btn btn-primary h-10">Save</button>
                                        </div>
                                        <a @click.prevent="cancelEditing" class="text-xs cursor-pointer">Cancel</a>
                                    </div>
                                </li>
                            </ol>
                            <div class="mt-4">
                                <div>
                                    <!-- <button class="btn btn-secondary block w-full">Add agenda item</button> -->
                                    <button @click="enableAddingNewParent" class="btn btn-secondary block w-full mb-4">
                                        Add Parent Item
                                    </button>
                                </div>
                            </div>
                            <div class="relative h-8">
                                <div
                                    class="absolute border -right-16 text-[10px] bottom-2 rounded text-center px-2 py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200"
                                >
                                    <div class="absolute left-0 right-0 text-green text-xxs bold -top-2.5">END</div>
                                    11:30pm
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="w-16 flex h-full justify-center py-4">
                                <div class="bg-gray-200 h-full relative left-1.5" style="width: 1px">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---->
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref} from 'vue';

const items = ref([]);
const is_editing = ref(false);
const isAddingNewParent = ref(false);
const addingChild = ref(false);
const currentParentId = ref(null);
const editingParentIndex = ref(-1);
const editingChildIndex = ref(-1);
const form = ref({data: {text: ''}, errors: {}});

const enableAddingNewParent = () => {
    isAddingNewParent.value = true;
    is_editing.value = false;
    addingChild.value = false;
    editingParentIndex.value = -1;
    editingChildIndex.value = -1;
    form.value.data.text = '';
    console.log('we are here', isAddingNewParent.value, addingChild.value, items);
};

const enableAddingChild = (pIndex) => {
    addingChild.value = true;
    currentParentId.value = items.value[pIndex].id; // Identify the parent
    editingParentIndex.value = pIndex; // Keep track of the parent being edited
    editingChildIndex.value = -1; // Reset child index since we're adding a new child
    form.value.data.text = ''; // Clear the form for new input
    is_editing.value = false; // Ensure we're not in editing mode
};

const enableEditing = (pIndex, cIndex) => {
    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;

    let itemText = '';
    if (cIndex === -1) {
        // Editing a parent
        itemText = items.value[pIndex].text;
        form.value.data.text = itemText.replace(/^[\d]+\.\s/, ''); // Remove numeric prefix
    } else {
        // Editing a child
        itemText = items.value[pIndex].children[cIndex].text;
        form.value.data.text = itemText.replace(/^[a-z]+\.\s/, ''); // Remove alphabetic prefix
    }
};
const submit = () => {
    if (form.value.data.text.trim() === '') {
        form.value.errors['text'] = ['This field is required.'];
        return;
    }

    if (is_editing.value) {
        if (editingChildIndex.value === -1) {
            // Editing a parent, extract and reuse the numeric prefix
            const existingText = items.value[editingParentIndex.value].text;
            const prefix = existingText.match(/^\d+\./)
                ? existingText.split(' ')[0]
                : `${editingParentIndex.value + 1}.`;
            items.value[editingParentIndex.value].text = `${prefix} ${form.value.data.text}`;
        } else {
            // Editing a child, extract and reuse the alphabetic prefix
            const existingText = items.value[editingParentIndex.value].children[editingChildIndex.value].text;
            const prefix = existingText.match(/^[a-z]\./i)
                ? existingText.split(' ')[0]
                : getAlphabetChar(editingChildIndex.value);
            items.value[editingParentIndex.value].children[
                editingChildIndex.value
            ].text = `${prefix} ${form.value.data.text}`;
        }
    } else {
        // Adding a new parent or child
        if (addingChild.value && currentParentId.value !== null) {
            const parentIndex = items.value.findIndex((item) => item.id === currentParentId.value);
            if (parentIndex !== -1) {
                const newChildIndex = items.value[parentIndex].children.length;
                const childPrefix = getAlphabetChar(newChildIndex);
                items.value[parentIndex].children.push({
                    id: `${parentIndex}-${newChildIndex}`,
                    text: `${childPrefix}. ${form.value.data.text}`,
                });
            }
        } else if (isAddingNewParent.value) {
            // Adding a new parent item
            const newText = `${items.value.length + 1}. ${form.value.data.text}`;
            items.value.push({id: items.value.length + 1, text: newText, children: []});
        }
    }

    // Clear form and reset state after submitting
    cancelEditing();
};

const cancelEditing = () => {
    is_editing.value = false;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = -1;
    editingChildIndex.value = -1;
    form.value.data.text = '';
};

const getAlphabetChar = (index) => {
    return String.fromCharCode(97 + index);
};
</script>

<style scoped>
    .font-medium {
        font-weight: bolder;
    }
    ol.agenda-list,
    ol.agenda-list > li > ol,
    ol.agenda-list > li > ol > li > ol {
        counter-reset: list-counter;
        left: -9px;
        list-style: none;
        margin-right: -9px;
        padding-left: 0;
        position: relative;
    }
    ol.agenda-list > li,
    ol.agenda-list > li > ol > li,
    ol.agenda-list > li > ol > li > ol > li {
        counter-increment: list-counter;
        padding-left: 32px;
        position: relative;
    }
    .hover\:cursor-pointer:hover {
        cursor: pointer;
    }

    .pl-7 {
        padding-left: 1.75rem;
    }
    .p-2 {
        padding: 0.5rem;
    }
    .border-blue {
        --tw-border-opacity: 1;
        border-color: rgb(64 104 235 / var(--tw-border-opacity));
    }
    .items-start {
        align-items: flex-start !important;
    }
</style>
