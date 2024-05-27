<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {Notification, NotificationRequestPayload} from '@//common/parsers/NotificationParser';
import {useGetNotificationsRequest, useUpdateNotificationRequest} from '@/common/api/requests/modules/user/useNotificationRequest';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formatTimeAgo} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import useAuthStore from '@/common/stores/auth.store';


const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const NotificationModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const userStore = useAuthStore();

const userId = userStore.user?.id;

//oneagnda
const notificationschema = yup.object({
    id: yup.string().required(),    
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    id: string;
}>({
    validationSchema: notificationschema,
    initialValues: {
        id: '',
    },
});

const updateNotification = async (notification:Notification) => {
    setFieldValue('id', notification.id);  
    await   onSubmit();
};


const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        const payload: NotificationRequestPayload = {
            id: values.id,
        };
        await useUpdateNotificationRequest(payload, userId, payload.id);
        await fetchNotifications();
        reset();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});

const reset = () => {
    setFieldValue('id', '');
};

const getNotifications = () => {
    return useQuery({
        queryKey: ['getNotificationsKey', userId],
        queryFn: async () => {
            const response = await useGetNotificationsRequest(userId.toString(), {paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading, data, refetch: fetchNotifications} = getNotifications();

const currentStatus = ref('unread');

const FilteredNotifications = computed(() => {
    if (!data.value) return []; // Check if data is not loaded

    if (currentStatus.value === 'unread') {
        return data.value.filter(meeting => {
            // Assuming you have a `date` field in your meetings
            return meeting.read_at === null;
        });
    } else {
        return data.value;
    }
});
const filterNotifications = (status: string) => {
    currentStatus.value = status;
    console.log('we', status, currentStatus.value);
    // currentStatus.value = currentStatus.value === 'all' ? 'unread' : 'all';
};
// console.log('Notification', NOTIFICATIONS);
</script>


<template>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card z-[1046] show custom-drop"  
         data-popper-placement="bottom-end">
        <div class="card-header flex items-center">
            <div class="flex items-center flex-1 w-full">
                <h2 class="card-header-title text-base mr-auto font-extrabold">Notifications</h2>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" class="btn btn-tool"
                        :class="{ 'btn-info': currentStatus === 'unread' }"
                        @click.prevent.stop="filterNotifications('unread')">
                    Unread
                </button>
                <button type="button" class="btn btn-tool"
                        :class="{ 'btn-info': currentStatus === 'all' }"
                        @click.prevent.stop="filterNotifications('all')">
                    All
                </button>

            </div>
        </div>
        <div class="overflow-y-auto" v-if="FilteredNotifications.length > 0">
            <div class="py-2">
                <div class="relative text-right">
                    <button type="button" class="ml-auto text-primary hover:bg-primary-100 
                                    bg-transparent py-1 px-2 rounded-[4px] text-sm flex gap-1 items-center 
                                    justify-center min-w-fit">
                        Mark all as read
                    </button>
                </div>
                <a v-for="notification in FilteredNotifications" :key='notification.id' 
                   href=""  
                   class="p-3 block flex text-gray-800">
                    <div class="avatar avatar-sm mr-4">
                        <div class="avatar-title  bg-primary-soft rounded-full text-primary">
                            <i class="far fa-calendar fa-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1" v-if="notification.data" @click.prevent.stop="updateNotification(notification)">
                        <h5 :class="{
                            'text-info font-semibold': notification.read_at === null, 
                            'text-black font-semibold': notification.read_at !== null}">
                            {{ notification.data.message }}
                        </h5>
                        <div class="text-muted mb-0 text-break text-sm">
                            <div class="flex items-center space-x-2">
                                <router-link v-if="notification.data.board_id" class="text-primary font-bold"
                                             :to="{ 
                                                 name: 'BoardDetails', 
                                                 params: { 
                                                     boardId: notification.data.board_id 
                                                
                                                 } 
                                             }
                                             ">
                                    View the Board
                                </router-link>
                                <router-link v-if="notification.data.meeting_id"  class="text-success font-bold"
                                             :to="{ 
                                                 name: 'BoardDetails', 
                                                 params: { 
                                                     boardId: notification.data.meeting_id 
                                                
                                                 } 
                                             }
                                             ">
                                    View the Meeting
                                </router-link>

                            </div>
                        </div>
                        <div class="text-danger text-sm">{{ formatTimeAgo(notification.created_at) }}</div>
                    </div> 
                </a>
                <hr>
            </div>
        </div>
    </div>
</template>
<style scoped>
.btn-info {
  background-color: #17a2b8;
  color: #fff;
}
.custom-drop{
    /* position: absolute; */
    inset: 0px 0px auto auto!important;
    margin: 0px!important;
    transform: translate(0px, 0px)!important;
}
.dropdown-menu.show {
    display: block!important;
}
.z-\[1046\] {
    z-index: 1046!important;
}
.show {
    opacity: 1!important;
}
.dropdown-menu {
    box-shadow: 2px 2px 30px 0 rgba(199, 207, 219, .5)!important;
}
.dropdown-menu-card {
    background-color: #fff!important;
    border-color: rgba(14, 33, 64, .1)!important;
    min-width: 370px!important;
    padding-bottom: 0!important;
    padding-top: 0!important;
}
.dropdown-menu {
    -webkit-animation: dropdownMenu .15s!important;
    animation: dropdownMenu .15s!important;
}
.dropdown-menu-end {
    --bs-position: end!important;
}
.dropdown-menu {
    background-clip: padding-box!important;
    background-color: #fff!important;
    border: 1px solid rgba(14, 33, 64, .1)!important;
    border-radius: .375rem!important;
    color: #0e2140!important;
    display: none!important;
    font-size: 1rem!important;
    list-style: none!important;
    margin: 0!important;
    min-width: 10rem!important;
    padding: .5rem!important;
    position: absolute!important;
    text-align: left!important;
    z-index: 1000!important;
    width: 350px !important;
    overflow-y: auto; /* Allows scrolling */
    max-height: 70vh; /* Maximum height before scrolling */
    min-height: 10vh; /* Minimum height for smaller content */
    /* other styles remain the same */
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
.text-primary {
    --tw-text-opacity: 1 !important;
}

.text-primary {
    color: rgb(64 104 235 / var(--tw-text-opacity)) !important;
}
.bg-primary, .bg-primary-soft {
    --tw-bg-opacity: 1 !important;
}
.bg-primary-soft {
    background-color: rgb(140 165 249 / var(--tw-bg-opacity)) !important;
}
.rounded-full {
    border-radius: 1px !important;
}
.avatar-title {
    align-items: center !important;
    background-color: #edf2f9 !important;
    color: #4b6c92 !important;
    display: flex !important;
    height: 100% !important;
    justify-content: center !important;
    line-height: 0 !important;
    width: 100% !important;
}
.bg-primary-soft {
    background-color: #e2e8fc !important;
}
</style>


