<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref, watch} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {number} from 'zod';
import {useCreateMeetingConflictRequest, useGetMeetingConflictsRequest, useUpdateMeetingConflictRequest} from '@/common/api/requests/modules/conflict/useConflictRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formatDate, resetfileDetails, setfileDetails,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Conflict, ConflictRequestPayload} from '@/common/parsers/ConflictParser';
import useAuthStore from '@/common/stores/auth.store';

const handleUnexpectedError = useUnexpectedErrorHandler();
const userStore = useAuthStore();


const route = useRoute();
const meetingId = route.params.meetingId as string;
const conflictId = ref<string | null>(null);
const action = ref('create');
const ConflictModal = ref<HTMLDialogElement | null>(null);
const userName = userStore.user?.first + ' ' + userStore.user?.last;


// conflict
const conflictschema = yup.object({
    name:yup.string().required(),
    address:yup.string().required(),
    nature:yup.string().required(),
    amount:yup.string().required(),
    ceased_date:yup.string().required(),
    remarks:yup.string().required(),
    conflict_id:yup.string().nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    name: string;
    address: string;
    nature: string,
    amount: string,
    ceased_date: string,
    remarks:string,
    conflict_id:null,

}>({
    validationSchema: conflictschema,
    initialValues: {
        name: userName,
        address:'',
        nature:'',
        amount:'',
        ceased_date:'',
        remarks:'',
        conflict_id:null,
    },
});

const openCreateConflictModal = () => {
    resetConflict();
    action.value = 'create';
    ConflictModal.value?.showModal();
};



const openEditConflictModal = (conflict:Conflict) => {
    resetConflict();
    conflictId.value = conflict.id.toString();
    action.value = 'edit';
    setFieldValue('address', conflict.address);
    setFieldValue('nature', conflict.nature);
    setFieldValue('amount', conflict.amount);
    setFieldValue('ceased_date', conflict.ceased_date);
    setFieldValue('remarks', conflict.remarks);

    ConflictModal.value?.showModal();
};
const resetConflict = () => {
    setFieldValue('address', '');
    setFieldValue('nature', '');
    setFieldValue('amount', '');
    setFieldValue('ceased_date', '');
    setFieldValue('remarks', '');
    setFieldValue('conflict_id', null);
    // Reset navigation path to initial state
    action.value = 'create';
    conflictId.value = null;
    resetfileDetails();
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        console.log('asafs');
        const payload: ConflictRequestPayload = {
            address: values.address,
            nature: values.nature,
            amount: values.amount,
            ceased_date: values.ceased_date,
            remarks: values.remarks,
            conflict_id: null,
        };
        if (action.value === 'create') {
            await useCreateMeetingConflictRequest(payload, meetingId);
        } else {
            const conflict_id = conflictId.value ? conflictId.value.toString() : null;
            payload.conflict_id = conflict_id;
            await useUpdateMeetingConflictRequest(payload, meetingId);
        }
        await fetchMeetingConflicts();
        resetConflict();
        ConflictModal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});



const getMeetingConflicts = () => {
    return useQuery({
        queryKey: ['getMeetingConflictsKey', meetingId],
        queryFn: async () => {
            const response = await useGetMeetingConflictsRequest(meetingId, {paginate: 'false'});
            return response.data;
        },
    });
};

const {isLoading, data: Conflicts, refetch: fetchMeetingConflicts} = getMeetingConflicts();

onMounted(async () => {
    await fetchMeetingConflicts();
});

</script>
<template>
    <div class="card">
        <div class="card-header">
            <div class="card-header flex items-center">
                <div class="flex items-center flex-1 w-full">
                    <h2 class="card-header-title h3">
                        Conflicts of Interest
                    </h2>
                </div>
                <div class="flex items-center space-x-2" v-if="Conflicts?.length === 0">
                    <button type="button" @click.prevent="openCreateConflictModal" class="btn btn-primary">
                        <i class="far fa fa-plus mr-2"></i> Add Your Conflict of Interest
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div id="member-list">
                <table class="table table-striped card-table">
                    <thead>
                        <tr>
                            <th scope="col" class="">No.</th>
                            <th scope="col" class="col-1">Name</th>
                            <th scope="col" class="col-1">Address</th>
                            <th scope="col" class="col-md-4 text-center">Nature Of Interest</th>
                            <th scope="col" class="col-1 text-center">Amount</th>
                            <th scope="col" class="col-1 text-center">Due Date</th>
                            <th scope="col" class="col-md-4 text-center">Remarks</th>
                            <th scope="col" class="col-1 text-center">Signed</th>
                            <th scope="col" class="col-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list" v-if="Conflicts">
                        <tr v-for="(conflict, idx) in Conflicts" :key="idx">
                            <td>{{ idx+1 }}.</td>
                            <td class="text-justified">{{ conflict?.membership?.user?.full_name }}</td>
                            <td class="text-justified">{{ conflict.address }}</td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bold text-primary">
                                    {{ conflict.nature }}
                                </p>
                            </td>
                            <td class="text-center">Kshs. {{ conflict.amount }}</td>
                            <td class="text-center">{{ formatDate(conflict.ceased_date) }}</td>
                            <td class="text-justifed">
                                <p class="text-sm font-weight-bold text-primary">
                                    {{ conflict.remarks }}
                                </p>
                            </td>
                            <td class="text-center">
                                {{ conflict.status }}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm"
                                        @click.prevent="openEditConflictModal(conflict)">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex justify-center col-md-6">
        <dialog id="conflictmodal" class="modal" ref="ConflictModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{ action === 'create' ? 'Create Conflict of Interest' : 'Update Conflict of Interest' }}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1 custom-modal">
                            <div  class="row">
                                <FormInput
                                    :labeled="true"
                                    :label="'Meeting Memmber'"
                                    name="name"
                                    class="col-md-6 w-full text-sm  text-white tracking-wide"
                                    :placeholder="'Meeting Memmber'"
                                    type="text"
                                    :disabled="true"
                                />
                                <FormInput
                                    :labeled="true"
                                    :label="'Address'"
                                    name="address"
                                    class="col-md-6 w-full text-sm  text-white tracking-wide"
                                    :placeholder="'Input Your Address'"
                                    type="text"
                                />
                                <FormTextBox
                                    :labeled="true"
                                    label="Nature of the Interest"
                                    name="nature"
                                    class="col-md-12 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Nature of the Interest"
                                    :rows="2"
                                />
                                <FormInput
                                    :labeled="true"
                                    :label="'Estimated Value Of The Interest (KSHS.)'"
                                    name="amount"
                                    class="col-md-6 w-full text-sm  text-white tracking-wide"
                                    :placeholder="'Estimated Value Of The Interest (KSHS.)'"
                                    type="number"
                                />
                                <FormDateTimeInput
                                    label="Due Date"
                                    name="ceased_date"
                                    :flow="['day']"
                                    class="col-md-6 w-full text-sm  text-white tracking-wide"
                                    placeholder="Select Due Date"
                                />
                                <FormTextBox
                                    :labeled="true"
                                    label="Remarks"
                                    name="remarks"
                                    class="col-md-12 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Remarks"
                                    :rows="2"
                                />
                            </div>
                            <button type="submit" class="btn btn-md mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{ action === 'create' ? 'Create Conflict of Interest' : 'Update Conflict of Interest' }}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</template>
<style scoped>

.btn-info {
  background-color: #17a2b8;
  color: #fff;
}
th button.list-sort {
    background-color: #f9fbfd;
    color: #4b6c92;
    font-size: .8125rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}
.avatar-sm {
    font-size: .8333333333rem;
    height: 2.5rem;
    width: 2.5rem;
}
.avatar {
    display: inline-block;
    font-size: 1rem;
    height: 3rem;
    position: relative;
    width: 3rem;
}
.rounded-full {
    border-radius: 9999px;
}
.avatar-img {
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    width: 100%;
}
img {
    display: block;
    max-width: 100%;
}
img, svg {
    vertical-align: middle;
}
</style>


