<template>
    <div class="flex gap-5">
        <div class="flex-1">
            <div class="card" style="min-height: 384px">
                <div class="card-body">
                    <div class="flex w-full">
                        <div class="flex-1">
                            {{ items }}
                            <ol data-list_format="num_la_lr"
                                class="agenda-list mb-0 border-l border-blue" >
                                <li class="mb-2 hover:border-gray-400"
                                    v-for="(item, pIndex) in items"
                                    :key="pIndex">
                                    <div class="rounded-lg border border-transparent hover:cursor-pointer
                                        border-blue -ml-7 p-2 pl-7 relative border-blue">
                                        <div class="absolute border -right-16 top-4 text-[10px] rounded text-center
                                            py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200 px-2">
                                            10:30pm
                                        </div>
                                        <div class="flex gap-2 items-start" @click="enableEditing(pIndex, -1)" >
                                            <div class="font-medium flex-1">
                                                {{ item.text }}
                                                <div class="text-sm text-gray-800 font-normal">
                                                    <p>decsritpion</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                                <div class="text-xs text-gray-600">
                                                    15 minutes
                                                </div>
                                            </div>
                                            <div>
                                                <ul class="list-none">
                                                    <li class="text-sm text-gray-800">
                                                        User Allocated
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                addingChild &&
                                                    currentParentId === item.id
                                            "
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
                                                <button
                                                    @click="submit"
                                                    class="btn btn-primary h-10"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                            <a
                                                @click.prevent="cancelEditing"
                                                class="text-xs cursor-pointer"
                                            >Cancel</a
                                            >
                                        </div>
                                        <button
                                            v-if="
                                                editingParentIndex !== pIndex &&
                                                    !addingChild
                                            "
                                            @click="enableAddingChild(pIndex)"
                                            class="ml-4 mt-2"
                                        >
                                            + Add sub item
                                        </button>
                                    </div>
                                    <ol class="min-h-6 border-l border-blue">
                                        <li
                                            class="mb-2 hover:border-gray-400"
                                            draggable="false"
                                            v-for="(child, cIndex) in item.children":key="cIndex">
                                            <div
                                                class="rounded-lg border border-transparent hover:cursor-pointer border-blue -ml-7 p-2 pl-7 relative border-blue"
                                            >
                                                <div
                                                    class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-white px-1"
                                                >
                                                    10:30pm
                                                </div>
                                                <!-- <div
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
                                                </div> -->
                                                <div
                                                    class="flex gap-2 items-start"
                                                    @click="
                                                        enableEditing(
                                                            pIndex,
                                                            cIndex,
                                                        )
                                                    "
                                                >
                                                    <div
                                                        class="font-medium flex-1"
                                                    >
                                                        {{ child.text }}
                                                        <div
                                                            class="text-sm text-gray-800 font-normal"
                                                        >
                                                            <p>Description</p>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex items-center gap-2 mt-1 h-6"
                                                    >
                                                        <div
                                                            class="text-xs text-gray-600"
                                                        >
                                                            10 minutes
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <ul class="list-none">
                                                            <li
                                                                class="text-sm text-gray-800"
                                                            >
                                                                Assignee
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                            <div class="mt-4">
                                <div>
                                    <div v-if="isAddingNewParent" class="mt-4">
                                        <div class="flex gap-x-2">
                                            <FormInput
                                                label="Agenda"
                                                name="oneagenda"
                                                class="w-full text-sm tracking-wide"
                                                placeholder="Enter Meeting Agenda"
                                                type="text"
                                            />
                                            <!-- <input
                                                type="text"
                                                v-model="form.data.text"
                                                class="form-control form-control-sm"
                                                placeholder="Enter parent item text"
                                                @keyup.enter="submit"
                                            /> -->
                                            <button
                                                @click="submit"
                                                class="btn btn-primary h-10"
                                            >
                                                Save
                                            </button>
                                        </div>
                                        <a
                                            @click.prevent="cancelEditing"
                                            class="text-xs cursor-pointer"
                                        >Cancel</a
                                        >
                                    </div>
                                    <!-- <button class="btn btn-secondary block w-full">Add agenda item</button> -->
                                    <button
                                        @click="enableAddingNewParent"
                                        class="btn btn-secondary block w-full mb-4"
                                    >
                                        Add Parent Item
                                    </button>
                                </div>
                            </div>
                            <div class="relative h-8">
                                <div class="absolute border -right-16 text-[10px] bottom-2 rounded
                                text-center px-2 py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200">
                                    <div class="absolute left-0 right-0 text-green text-xxs bold -top-2.5">
                                        END
                                    </div>
                                    11:30pm
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="w-16 flex h-full justify-center py-4">
                                <div class="bg-gray-200 h-full relative left-1.5" style="width: 1px">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---->
            </div>
        </div>
        <div
            :class="{
                hidden: !is_editing,
                'md:block': true,
                'w-[350px]': true,
            }"
        >
            <div class="w-[350px] relative">
                <div class="w-[350px]">
                    <div class="card mb-0">
                        <div class="card-body">
                            <FormInput
                                label="Agenda"
                                name="agenda"
                                class="w-full text-sm tracking-wide"
                                placeholder="Enter Meeting Agenda"
                                type="text"
                            />
                            <FormTextBox
                                label="Agenda Description"
                                name="description"
                                class=""
                                placeholder="Enter Agenda  Description"
                                :rows="2"
                            />
                            <FormSelect
                                name="duration"
                                label="Duration"
                                placeholder="Select Duration"
                                :options="DurationOptions"
                            />
                            <div class="form-group">
                                <label
                                    class="text-xs uppercase font-medium text-gray-700 tracking-wide"
                                >People Responsible</label
                                >
                                <div
                                    :class="[
                                        'multiselect-container',
                                        { error: !!errorMessage },
                                    ]"
                                >
                                    <Multiselect
                                        id="assignees"
                                        v-model="selectedMemberIds"
                                        mode="tags"
                                        placeholder="Choose your stack"
                                        :close-on-select="false"
                                        :filter-results="false"
                                        :min-chars="1"
                                        :resolve-on-load="false"
                                        :delay="0"
                                        :searchable="true"
                                        :options="Users"
                                        :valueProp="'id'"
                                        :trackBy="'id'"
                                        :label="'name'"
                                        :class="[
                                            'multiselect-container',
                                            { error: !!errorMessage },
                                        ]"
                                        @select="selectedUsers()"
                                        @deselect="removeselectedUsers()"
                                    />
                                    <div v-if="errorMessage" class="message">
                                        {{ errorMessage }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button
                                    class="btn btn-link btn-sm text-danger h-7"
                                >
                                    Delete
                                </button>
                                <div>
                                    <button
                                        @click.prevent="cancelEditing"
                                        class="btn btn-secondary btn-sm ml-1 mr-1"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        @click="submit"
                                        class="btn btn-sm btn-primary ml-1 mr-1"
                                    >
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
        <div
            :class="{ hidden: is_editing, 'md:block': true, 'w-[350px]': true }"
        >
            <div class="w-[350px] relative">
                <div class="w-[350px]">
                    <div
                        class="bg-gray-200 rounded-lg h-96 flex items-center justify-center"
                    >
                        <div class="text-center text-gray-700">
                            Select an agenda item to edit
                            <br role="presentation" data-uw-rm-sr="" />
                            <div class="text-xl mt-1">
                                <svg
                                    class="svg-inline--fa fa-turn-down-left"
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="far"
                                    data-icon="turn-down-left"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"
                                    data-fa-i2svg=""
                                >
                                    <path
                                        fill="currentColor"
                                        d="M6.5 271.6c-8.7 9.2-8.7 23.7 0 32.9l121.4 129c8.8 9.3 21 14.6 33.7 14.6c25.6 0 46.3-20.7 46.3-46.3l0-41.7 144 0c88.4 0 160-71.6 160-160l0-112c0-30.9-25.1-56-56-56l-32 0c-30.9 0-56 25.1-56 56l0 120c0 4.4-3.6 8-8 8l-152 0 0-41.7c0-25.6-20.7-46.3-46.3-46.3c-12.8 0-25 5.3-33.7 14.6L6.5 271.6zm153.5-93l0 61.5c0 13.3 10.7 24 24 24l176 0c30.9 0 56-25.1 56-56l0-120c0-4.4 3.6-8 8-8l32 0c4.4 0 8 3.6 8 8l0 112c0 61.9-50.1 112-112 112l-168 0c-13.3 0-24 10.7-24 24l0 61.5L57 288 160 178.5z"
                                    ></path>
                                </svg>
                                <!-- <i class="fa-regular fa-turn-down-left"></i> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import * as yup from 'yup';
import {
    useCreateBoardRequest,
    useUpdateBoardRequest,
} from '@/common/api/requests/modules/board/useBoardRequest';
import {useGetStaffsRequest} from '@/common/api/requests/staff/useStaffRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    resetCoverImage,
    resetIconImage,
} from '@/common/customisation/Breadcrumb';
import {Agenda} from '@/common/parsers/agendaParser';
import {
    BoardRequestPayload,
    SelectedResult,
} from '@/common/parsers/boadParser';
import {User} from '@/common/parsers/userParser';
import Multiselect from '@@/@vueform/multiselect';

const selectedMemberIds = ref<string[]>([]);
const allUsers = ref<User[]>([]);
const allAgendas = ref<Agenda[]>([]);
const selectedAgenda = ref<Agenda | null>(null);

const items = ref([]);
const is_editing = ref(false);
const isAddingNewParent = ref(false);
const addingChild = ref(false);
const currentParentId = ref(null);
const editingParentIndex = ref(-1);
const editingChildIndex = ref(-1);
const form = ref({
    data: {
        text: '',
    },
    errors: {},
});

const {errorMessage} = useField('assignees');

const handleUnexpectedError = useUnexpectedErrorHandler();
const schema = yup.object({
    meeting_id: yup.mixed().required(),
    agenda_id: yup.string(),
    sub_agenda_id: yup.string(),
    title: yup.string().required(),
    duration: yup.string().required(),
    description: yup.string().required(),
    assignees: yup.array().of(yup.string()).required('Agenda is required.'),
});
const {handleSubmit, setErrors, setFieldValue, values} = useForm<{
    meeting_id: string;
    title: string;
    agenda_id: string;
    sub_agenda_id: string;
    duration: string;
    description: string;
    assignees: string[];
}>({
    validationSchema: schema,
    initialValues: {
        meeting_id: '',
        agenda_id: '',
        sub_agenda_id: '',
        title: '',
        duration: '',
        description: '',
        assignees: [],
    },
});

//oneagnda
const agendaschema = yup.object({
    meeting_id: yup.mixed().required(),
    title: yup.string().required(),
});
const {
    handleSubmit: handleagendaSubmit,
    setErrors: setAgendaErrors,
    setFieldValue: setAgendaFieldValue,
    values: AgendaValues,
} = useForm<{
    meeting_id: string;
    title: string;
}>({
    validationSchema: agendaschema,
    initialValues: {
        meeting_id: '1',
        title: '',
    },
});

const enableAddingNewParent = () => {
    isAddingNewParent.value = true;
    is_editing.value = false;
    addingChild.value = false;
    editingParentIndex.value = -1;
    editingChildIndex.value = -1;
    // form.value.data.text = '';
    setAgendaFieldValue('title', '');
    console.log(
        'we are here',
        isAddingNewParent.value,
        addingChild.value,
        items,
    );
};

const enableAddingChild = (pIndex) => {
    addingChild.value = true;
    currentParentId.value = items.value[pIndex].id; // Identify the parent
    editingParentIndex.value = pIndex; // Keep track of the parent being edited
    editingChildIndex.value = -1; // Reset child index since we're adding a new child
    // form.value.data.text = ''; // Clear the form for new input
    setAgendaFieldValue('title', '');
    is_editing.value = false; // Ensure we're not in editing mode
};

const enableEditing = (pIndex, cIndex) => {
    selectedAgenda.value = pIndex;

    is_editing.value = true;
    isAddingNewParent.value = false;
    addingChild.value = false;
    editingParentIndex.value = pIndex;
    editingChildIndex.value = cIndex;

    const itemText = '';
    if (cIndex === -1) {
        // Editing a parent
        // itemText = items.value[pIndex].text;

        // form.value.data.text = itemText.replace(/^[\d]+\.\s/, ''); // Remove numeric prefix
        setAgendaFieldValue('title',  pIndex.title);
        setFieldValue('meeting_id', pIndex.meeting_id);
        setFieldValue('agenda_id', pIndex.agenda_id);
        setFieldValue('sub_agenda_id', pIndex.sub_agenda_id);
        setFieldValue('duration', pIndex.duration);
        setFieldValue('description', pIndex.description);
        setFieldValue('assignees', pIndex.assignees);
    } else {
        // Editing a child
        const title = items.value[pIndex].children[cIndex].title;
        const meeting_id = items.value[pIndex].children[cIndex].meeting_id;
        const agenda_id = items.value[pIndex].children[cIndex].agenda_id;
        const sub_agenda_id = items.value[pIndex].children[cIndex].sub_agenda_id;
        const duration = items.value[pIndex].children[cIndex].duration;
        const description = items.value[pIndex].children[cIndex].description;
        const assignees = items.value[pIndex].children[cIndex].assignees;
        // form.value.data.text = itemText.replace(/^[a-z]+\.\s/, ''); // Remove alphabetic prefix
        setFieldValue('meeting_id', title);
        setFieldValue('agenda_id', meeting_id);
        setFieldValue('sub_agenda_id', agenda_id);
        setFieldValue('title', sub_agenda_id);
        setFieldValue('duration', duration);
        setFieldValue('description', description);
        setFieldValue('assignees', assignees);
    }
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        const payload: BoardRequestPayload = {
            name: values.name,
            description: values.description,
            icon: values.icon,
            cover: values.cover, // Fallback if not a file
        };
        if (action.value === 'create') {
            await useCreateBoardRequest(payload);
        } else {
            if (selectedBoard.value?.id) {
                console.log('Selected Board ID:', selectedBoard.value.id);
                await useUpdateBoardRequest(
                    payload,
                    selectedBoard.value.id,
                );
            }
        }
        await fetchMeetingAgenda();
        resetForm();
        showCreate.value = false;
        boardmodal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const submit = () => {
    // if (form.value.data.text.trim() === '') {
    //     form.value.errors['text'] = ['This field is required.'];
    //     return;
    // }

    if (is_editing.value) {
        if (editingChildIndex.value === -1) {
            // Editing a parent, extract and reuse the numeric prefix
            const existingText = items.value[editingParentIndex.value].text;
            const prefix = existingText.match(/^\d+\./)
                ? existingText.split(' ')[0]
                : `${editingParentIndex.value + 1}.`;
            items.value[editingParentIndex.value].text =
                `${prefix} ${form.value.data.text}`;
        } else {
            // Editing a child, extract and reuse the alphabetic prefix
            const existingText =
                items.value[editingParentIndex.value].children[
                    editingChildIndex.value
                ].text;
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
            const parentIndex = items.value.findIndex(
                (item) => item.id === currentParentId.value,
            );
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
            items.value.push({
                id: items.value.length + 1,
                text: newText,
                children: [],
            });
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

const durationOptions = [
    {name: '- none -', value: '0'},
    {name: '5 minutes', value: '5'},
    {name: '10 minutes', value: '10'},
    {name: '15 minutes', value: '15'},
    {name: '20 minutes', value: '20'},
    {name: '25 minutes', value: '25'},
    {name: '30 minutes', value: '30'},
    {name: '35 minutes', value: '35'},
    {name: '40 minutes', value: '40'},
    {name: '45 minutes', value: '45'},
    {name: '50 minutes', value: '50'},
    {name: '55 minutes', value: '55'},
    {name: '60 minutes', value: '60'},
];

const selectedUsers = () => {
    setFieldValue('assignees', selectedMemberIds.value);
};
const removeselectedUsers = () => {
    setFieldValue('assignees', selectedMemberIds.value);
};

const Users = computed(() => {
    const resul: SelectedResult[] = [];
    if (allUsers.value && allUsers.value?.length > 0) {
        allUsers.value.reduce((accumulator, currentUser) => {
            accumulator.push({
                id: currentUser.id,
                name: `${currentUser.full_name}`,
            });
            return accumulator;
        }, resul);
    }
    return resul;
});
const DurationOptions = computed(() => {
    return durationOptions;
});

const getUsers = async () => {
    const data = await useGetStaffsRequest({paginate: 'false'});
    allUsers.value = data.data;
};
const getMeetingAgendas = async () => {
    const data = await useGetMeetingAgendasRequest({paginate: 'false'}, payload);
    allAgendas.value = data.data;
};
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Agendas'}));
    getUsers();
});

const {isLoading, data, refetch: fetchMeetingAgendas} = getMeetingAgendas();
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
.hidden {
    display: none !important;
}
</style>
