<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {onMounted,ref} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import {useGetSingleBoadMeetingRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest'; // Import your API function
import {formatDate,formattedDate} from '@/common/customisation/Breadcrumb';
import {Meeting} from '@/common/parsers/meetingParser';
// Define a reactive reference for storing meeting data
// const meeting = ref<Meeting>();

// Get the route instance
const route = useRoute();
const router = useRouter();

function goBack() {
    router.back();
}
// Extract the id parameter from the route
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;

const fallbackCopyTextToClipboard = (text) => {
    const textArea = document.createElement('textarea');
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = '0';
    textArea.style.left = '0';
    textArea.style.position = 'fixed';

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        const successful = document.execCommand('copy');
        const msg = successful ? 'successful' : 'unsuccessful';
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
};

// Usage
const copyLinkToClipboard = async (link) => {
    if (!navigator.clipboard) {
        // Fallback method
        fallbackCopyTextToClipboard(link);
        alert('Link copied to clipboard, paste it on your browser or share it to your platform');
        return;
    }

    try {
        await navigator.clipboard.writeText(link);
        alert('Link copied to clipboard!');
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
};


const getMeeting = () => {
    return useQuery({
        queryKey: ['getMeetingKey', boardId, meetingId],
        queryFn: async () => {
            const response = await useGetSingleBoadMeetingRequest(meetingId);
            window.dispatchEvent(new CustomEvent('updateTitle', {detail: response.data.title + ' Meeting'}));
            return response.data;
        },
    });
};



const {isLoading, data: Meeting, refetch: fetchMeeting} = getMeeting();

</script>
<template>
    <div class="card">
        <div class="card-header flex items-center">
            <h2 class="card-header-title h3">Details</h2>
            <!-- <div class="ml-auto flex items-center space-x-2">
                <div id="calendar-select" class="dropdown">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                           role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            Add to calendar
                        </a>
                        <div class="dropdown-menu --73" aria-labelledby="navbarDropdown"
                             style="    left: -73px !important;">
                            <a class="dropdown-item" href="#">
                                <i aria-hidden="true" class="far fa-google mr-2"></i>
                                Google
                            </a>
                            <a class="dropdown-item" href="#">
                                <i aria-hidden="true" class="far fa-yahoo mr-2"></i>
                                Yahoo
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Delete Meeting</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="card-body">
            <div class="space-y-6">
                <div class=" flex items-start">
                    <div class="mr-4 w-6 text-muted">
                        <svg aria-hidden="true" class="svg-inline--fa fa-calendar-day h-6 w-6"
                             focusable="false" data-prefix="far" data-icon="calendar-day" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M128 0c13.3 0 24 10.7 24 24V64H296V24c0-13.3 10.7-24 24-24s24 10.7 24
                                                    24V64h40c35.3 0 64 28.7 64 64v16 48V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192 144 128C0
                                                    92.7 28.7 64 64 64h40V24c0-13.3 10.7-24 24-24zM400 192H48V448c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2
                                                    16-16V192zM112 256h96c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16H112c-8.8 0-16-7.2-16-16V272c0-8.8
                                                    7.2-16 16-16z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="h3 mb-0">
                            <p class="m-0">
                                {{ Meeting?.title}}
                            </p>
                            <p class="m-0">
                            <div  v-for="schedule in Meeting?.schedules" :key="schedule.id">
                                {{ formatDate(schedule.date) }}
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-6 mr-4 mt-2 text-muted">
                        <svg aria-hidden="true" class="svg-inline--fa fa-video h-6 w-6 mx-auto" focusable="false"
                             data-prefix="far" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 576 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M64 112c-8.8 0-16 7.2-16 16V384c0 8.8 7.2 16 16 16H320c8.8
                                                    0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H64zM0 128C0 92.7 28.7 64 64 64H320c35.3 0 64
                                                    28.7 64 64v33V351v33c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM528
                                                    363.4V148.6L416 199V146.4L520.3 99.5c5.1-2.3 10.6-3.5 16.2-3.5c21.8 0 39.5 17.7
                                                    39.5 39.5v241c0 21.8-17.7 39.5-39.5 39.5c-5.6 0-11.1-1.2-16.2-3.5L416 365.6V313l112 50.4z">
                            </path>
                        </svg>
                        <!-- <i aria-hidden="true" class="fa-regular h-6 w-6 fa-video mx-auto"></i> -->
                    </div>
                    <div>
                        <div class="flex mb-2 flex-wrap" v-if="Meeting?.link">
                            <!-- Join Web Conference Button -->
                            <a target="_blank" :href="Meeting?.link"
                               class="btn btn-primary whitespace-nowrap mr-2"
                               aria-label="Join Web Conference - open in a new tab">
                                Join Web Conference
                            </a>

                            <!-- Copy Link Button -->
                            <button type="button" @click="copyLinkToClipboard(Meeting?.link)"
                                    title="Copy web conference link" aria-label="Copy web conference link"
                                    class="btn btn-primary mr-2">
                                <i class="fas fa-link"></i>
                            </button>

                            <!-- Run a Video Test Button -->
                            <!-- Ensure this link is correctly bound as well if needed -->
                            <a :href="Meeting?.link" target="_blank"
                               aria-label="Run a Video Test - open in a new tab">
                                <button type="button" class="text-primary hover:bg-primary-100 bg-transparent py-2 px-3
                                rounded-md text-base flex gap-1 items-center justify-center min-w-fit">
                                    Run a Video Test
                                </button>
                            </a>
                        </div>
                        <div v-else>
                            Physical Meeting at {{ Meeting?.location }}
                        </div>
                    </div>

                </div>
                <!-- <div class="flex items-center">
                    <div class="w-6 mr-4 text-center text-muted"> -->
                <!-- <svg aria-hidden="true" class="svg-inline--fa fa-phone h-6 w-6 mx-auto"
                             focusable="false" data-prefix="far" data-icon="phone" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M375.8 275.2c-16.4-7-35.4-2.4-46.7
                                                    11.4l-33.2 40.6c-46-26.7-84.4-65.1-111.1-111.1L225.3 183c13.8-11.3
                                                    18.5-30.3 11.4-46.7l-48-112C181.2 6.7 162.3-3.1 143.6 .9l-112 24C13.2
                                                    28.8 0 45.1 0 64v0C0 295.2 175.2 485.6 400.1 509.5c9.8 1 19.6 1.8 29.6
                                                    2.2c0 0 0 0 0 0c0 0 .1 0 .1 0c6.1 .2 12.1 .4 18.2 .4l0 0c18.9 0 35.2-13.2
                                                    39.1-31.6l24-112c4-18.7-5.8-37.6-23.4-45.1l-112-48zM441.5 464C225.8 460.5
                                                    51.5 286.2 48.1 70.5l99.2-21.3 43 100.4L154.4 179c-18.2 14.9-22.9 40.8-11.1
                                                    61.2c30.9 53.3 75.3 97.7 128.6 128.6c20.4 11.8 46.3 7.1 61.2-11.1l29.4-35.9
                                                    100.4 43L441.5 464zM48 64v0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0s0 0 0 0">
                            </path>
                        </svg> -->
                <!-- <i aria-hidden="true" class="fa-regular h-6 w-6 fa-phone mx-auto"></i> -->
                <!-- </div> -->
                <!-- <p class="m-0">+1 888 998 2469</p> -->
                <!-- </div> -->
                <!-- <div class="flex items-center">
                    <div class="w-6 mr-4 text-center text-muted text-sm">
                        PIN
                    </div>
                    <p class="m-0">15854732#</p>
                </div> -->
                <div class="flex items-center">
                    <p class="m-0 text-sm">{{ Meeting?.description }}</p>
                </div>
                <div>
                    <!-- <a href="https://app.boardable.com/felix-1/groups/dff155-board"
                        class="badge badge-soft">{{  meeting?.board?.title }}  Board</a>
                    <a href="" class="badge badge-soft">{{  meeting?.title }}</a> -->
                </div>
            </div>
        </div>
    </div>
</template>
