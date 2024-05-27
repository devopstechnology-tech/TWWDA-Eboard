<template>
    <div class="card mb-0">
        <div v-for="(item, pIndex) in items" :key="pIndex" class="mt-3">
            <div v-if="editingParentIndex === pIndex && editingChildIndex === -1 && !addingChild">
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
            <div v-else @click="enableEditing(pIndex, -1)" class="text-sm text-gray-800 cursor-pointer">
                {{ item.text }}
            </div>

            <div v-for="(child, cIndex) in item.children" :key="cIndex" class="ml-4">
                <div v-if="editingParentIndex === pIndex && editingChildIndex === cIndex">
                    <div class="flex gap-x-2">
                        <input
                            type="text"
                            v-model="form.data.text"
                            class="form-control form-control-sm"
                            placeholder="Edit sub item text"
                            @keyup.enter="submit"
                        />
                        <button @click="submit" class="btn btn-primary h-10">Save</button>
                    </div>
                    <a @click.prevent="cancelEditing" class="text-xs cursor-pointer">Cancel</a>
                </div>
                <div v-else @click="enableEditing(pIndex, cIndex)" class="text-sm text-gray-600 cursor-pointer">
                    {{ child.text }}
                </div>
            </div>

            <!-- Conditionally display the input for adding a new child right here -->
            <div v-if="addingChild && currentParentId === item.id" class="ml-4 mt-2">
                <div class="flex gap-x-2">
                    <input
                        type="text"
                        v-model="form.data.text"
                        class="form-control form-control-sm"
                        placeholder="Enter sub item text"
                        @keyup.enter="submit"
                    />
                    <button @click="submit" class="btn btn-primary h-10">Save</button>
                </div>
                <a @click.prevent="cancelEditing" class="text-xs cursor-pointer">Cancel</a>
            </div>

            <!-- Show "Add sub item" button only if not currently adding a child -->
            <button
                v-if="editingParentIndex !== pIndex && !addingChild"
                @click="enableAddingChild(pIndex)"
                class="ml-4 mt-2"
            >
                + Add sub item
            </button>
        </div>

        <!-- Input for Adding New Parent at the top -->
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
        </div>
        <button @click="enableAddingNewParent" class="btn btn-secondary block w-full mb-4">Add Parent Item</button>
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
