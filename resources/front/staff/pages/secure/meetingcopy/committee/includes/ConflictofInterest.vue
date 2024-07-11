<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {useCreateMeetingConflictRequest, useGetMeetingConflictsRequest, useUpdateMeetingConflictRequest} from '@/common/api/requests/modules/conflict/useConflictRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formatDate, resetfileDetails} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Conflict, ConflictRequestPayload} from '@/common/parsers/ConflictParser';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();

const handleUnexpectedError = useUnexpectedErrorHandler();
const userStore = useAuthStore();

const route = useRoute();
const meetingId = route.params.meetingId as string;
const conflictId = ref<string | null>(null);
const action = ref('create');
const ConflictModal = ref<HTMLDialogElement | null>(null);
const userName = userStore.user?.first + ' ' + userStore.user?.last;

const conflictschema = yup.object({
    name: yup.string().required(),
    address: yup.string().required(),
    nature: yup.string().required(),
    amount: yup.string().required(),
    ceased_date: yup.string().required(),
    remarks: yup.string().required(),
    conflict_id: yup.string().nullable(),
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
    remarks: string,
    conflict_id: null,
}>({
    validationSchema: conflictschema,
    initialValues: {
        name: userName,
        address: '',
        nature: '',
        amount: '',
        ceased_date: '',
        remarks: '',
        conflict_id: null,
    },
});

const openCreateConflictModal = () => {
    resetConflict();
    action.value = 'create';
    ConflictModal.value?.showModal();
};

const openEditConflictModal = (conflict: Conflict) => {
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
    action.value = 'create';
    conflictId.value = null;
    resetfileDetails();
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
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

// Check if the current user has any conflicts
const userHasConflict = computed(() => {
    return Conflicts?.value?.some(conflict => conflict?.membership?.user?.id === authStore?.user?.id);
});
</script>
<template>
    <div v-if="authStore.hasPermission(['view conflicts of interest'])">
        <div class="card">
            <div class="card-header">
                <div class="card-header flex items-center">
                    <div class="flex items-center flex-1 w-full">
                        <h2 class="card-header-title h3">
                            Conflicts of Interest
                        </h2>
                    </div>
                    <div v-if="authStore.hasPermission(['create conflict of interest'])" 
                         class="flex items-center space-x-2">
                        <button type="button" v-if="!userHasConflict" 
                                @click.prevent="openCreateConflictModal" class="btn btn-primary">
                            <i class="far fa fa-plus mr-2"></i> Add Your Conflict of Interest
                        </button>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row" v-if="Conflicts">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3" v-for="(conflict, idx) in Conflicts" :key="idx">
                        <div class="card card-outline card-primary h-100"
                        >
                            <div class="card-body box-profile">
                                <div class="text-center mb-3">
                                    <h3 class="profile-username text-primary">
                                        {{ conflict?.membership?.user?.full_name }}
                                    </h3>
                                    <p class="text-muted">{{ conflict.address }}</p>
                                </div>

                                <div class="info-section">
                                    <span class="text-bold text-danger">Nature Of Interest: </span>
                                    <span class="text-primary">{{ conflict.nature }}</span>
                                </div>
            
                                <div class="info-section">
                                    <span class="text-bold text-danger">Amount: </span>
                                    <span>Kshs. {{ conflict.amount }}</span>
                                </div>

                                <div class="info-section">
                                    <span class="text-bold text-danger">Due Date: </span>
                                    <span>{{ formatDate(conflict.ceased_date) }}</span>
                                </div>

                                <div class="info-section">
                                    <span class="text-bold text-danger">Remarks: </span>
                                    <span class="text-primary">{{ conflict.remarks }}</span>
                                </div>

                                <div class="info-section">
                                    <span class="text-bold text-danger">Signed: </span>
                                    <span>{{ conflict.status }}</span>
                                </div>
                                <div class="text-center mt-3"  
                                     v-if="authStore.hasPermission(['edit conflict of interest'])">
                                    <button  v-if="conflict?.membership?.user?.id === authStore?.user?.id"
                                             class="btn btn-success btn-sm" 
                                             @click.prevent="openEditConflictModal(conflict)">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <div class="row">
                                    <FormInput
                                        :labeled="true"
                                        :label="'Meeting Member'"
                                        name="name"
                                        class="col-md-6 w-full text-sm text-white tracking-wide"
                                        :placeholder="'Meeting Member'"
                                        type="text"
                                        :disabled="true"
                                    />
                                    <FormInput
                                        :labeled="true"
                                        :label="'Address'"
                                        name="address"
                                        class="col-md-6 w-full text-sm text-white tracking-wide"
                                        :placeholder="'Input Your Address'"
                                        type="text"
                                    />
                                    <FormTextBox
                                        :labeled="true"
                                        label="Nature of the Interest"
                                        name="nature"
                                        class="col-md-12 w-full text-sm text-white tracking-wide"
                                        placeholder="Enter Nature of the Interest"
                                        :rows="2"
                                    />
                                    <FormInput
                                        :labeled="true"
                                        :label="'Estimated Value Of The Interest (KSHS.)'"
                                        name="amount"
                                        class="col-md-6 w-full text-sm text-white tracking-wide"
                                        :placeholder="'Estimated Value Of The Interest (KSHS.)'"
                                        type="number"
                                    />
                                    <FormDateTimeInput
                                        label="Due Date"
                                        name="ceased_date"
                                        :flow="['day']"
                                        class="col-md-6 w-full text-sm text-white tracking-wide"
                                        placeholder="Select Due Date"
                                    />
                                    <FormTextBox
                                        :labeled="true"
                                        label="Remarks"
                                        name="remarks"
                                        class="col-md-12 w-full text-sm text-white tracking-wide"
                                        placeholder="Enter Remarks"
                                        :rows="2"
                                    />
                                </div>
                                <button type="submit" class="btn btn-md mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                    {{ action === 'create' ? 
                                    'Create Conflict of Interest' : 'Update Conflict of Interest' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </form>
            </dialog>
        </div>
    </div>
    <div v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
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
.profile-username {
    font-size: 1.25rem;
}
.info-section {
    margin-bottom: 1rem;
}
</style>
