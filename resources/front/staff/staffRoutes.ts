/* eslint-disable max-len */
import {RouteRecordRaw} from 'vue-router';
import {
    AGENDAS,
    ALMANAC,
    BOARDS,
    CALENDAR,
    CHANGE_PASSWORD,
    DASHBOARD,
    DISCUSSIONS,
    FORGOT_PASSWORD,
    LOGIN,
    MEETINGS,
    NOTIFICATIONS,
    POLLS,
    REGISTER,
    SETTINGS,
    TASKS,
    USERS,
} from '@/common/constants/staffRouteNames';
import requireStaffAuthentication from '@/common/guards/requireStaffAuthentication';
import requireStaffGuest from '@/common/guards/requireStaffGuest';


const staffRoutes: RouteRecordRaw[] = [
    {
        beforeEnter: [
            requireStaffGuest,
        ],
        children: [
            {
                beforeEnter: requireStaffGuest,
                component: () => import('@/staff/pages/public/ForgotPassword.vue'),
                name: FORGOT_PASSWORD,
                path: 'forgot-password',
                meta: {title: 'Forgot Password'},
            },
            {
                beforeEnter: requireStaffGuest,
                component: () => import('@/staff/pages/public/ChangePassword.vue'),
                name: CHANGE_PASSWORD,
                path: 'change-password',
                meta: {title: 'Change Password'},
            },
            {
                beforeEnter: requireStaffGuest,
                component: () => import('@/staff/pages/public/Register.vue'),
                name: REGISTER,
                path: 'accept-invitation',
                meta: {title: 'Register'},
                props: (route) => (
                    {token: route.query.token}
                ),
            },
            {
                beforeEnter: requireStaffGuest,
                component: () => import('@/staff/pages/public/Login.vue'),
                name: LOGIN,
                path: '',
                meta: {title: 'Login'},
            },

        ],
        component: () => import('@/staff/StaffRoot.vue'),
        path: '/',
    },
    {
        beforeEnter: [
            requireStaffAuthentication,
        ],
        children:
            [
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/Dashboard.vue'),
                    name: DASHBOARD,
                    path: 'dashboard',
                    meta: {title: 'Dashboard'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/board/Boards.vue'),
                    name: BOARDS,
                    path: 'boards',
                    meta: {title: 'Boards & Committee'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/board/BoardDetails.vue'),
                    // Ensure this component is created
                    name: 'BoardDetails', // A unique name for the route
                    path: '/board/:boardId', // Dynamic segment to capture the board ID
                    meta: {title: 'Board Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/board/includes/document/document.vue'),
                    // Ensure this component is created
                    name: 'BoardMediaDetails', // A unique name for the route
                    path: '/board/:boardId/folder/:folderId/media/:mediaId', // Dynamic segment to capture the board ID
                    meta: {title: 'Media Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/MeetingsDetails.vue'),
                    // Ensure this component is created
                    name: 'BoardMeetingDetails', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Board Meeting Details'},
                },
                // {
                //     beforeEnter: requireStaffAuthentication,
                //     component: () => import('@/staff/pages/secure/meeting/includes/Minute.vue'),
                //     // Ensure this component is created
                //     name: 'BoardMeetingMinutes', // A unique name for the route
                //     path: '/board/:boardId/meeting/:meetingId/minutes', // Dynamic segment to capture the board ID & meting id
                //     meta: {title: 'Board Meeting Minutes Details'},
                //     props: (route) => {
                //         const agendas = route.query.agendas;
                //         let parsedAgendas = null;
                //         if (typeof agendas === 'string') { // Ensure agendas is a string before decoding and parsing
                //             try {
                //                 parsedAgendas = JSON.parse(decodeURIComponent(agendas));
                //            } catch (error) {
                //                 console.error('Failed to parse agendas:', error);
                //                 parsedAgendas = null; // Set to null if parsing fails
                //            }
                //        }
                //         return {
                //             boardId: route.params.boardId,
                //             meetingId: route.params.meetingId,
                //             agendas: parsedAgendas,
                //        };
                //    },
                //},
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/includes/Minute.vue'),
                    // Ensure this component is created
                    name: 'BoardMeetingMinutes', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/minutes', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Board Meeting Minutes Details'},
                    props: route => ({
                        boardId: route.params.boardId,
                        meetingId: route.params.meetingId,
                        defaultMinutes: route.query.defaultMinutes === 'true',  // Interpret as boolean
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/Meetings.vue'),
                    name: MEETINGS,
                    path: 'meetings',
                    meta: {title: 'Meetings'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/MeetingsDetails.vue'),
                    // Ensure this component is created
                    name: 'MeetingDetails', // A unique name for the route
                    path: '/meeting/:id', // Dynamic segment to capture the board ID
                    meta: {title: 'Meetings Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/includes/document/document.vue'),
                    // Ensure this component is created
                    name: 'MediaDetails', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/folder/:folderId/media/:mediaId', // Dynamic segment to capture the board ID
                    meta: {title: 'Media Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/almanac/Almanac.vue'),
                    name: ALMANAC,
                    path: 'almanac',
                    meta: {title: 'Almanac'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/discussion/Discussions.vue'),
                    name: DISCUSSIONS,
                    path: 'discussions',
                    meta: {title: 'Discussions'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/discussion/DiscussionsDetails.vue'),
                    // Ensure this component is created
                    name: 'DiscussionDetails', // A unique name for the route
                    path: '/discussion/:id', // Dynamic segment to capture the board ID
                    meta: {title: 'Discussions Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/task/Tasks.vue'),
                    name: TASKS,
                    path: 'tasks',
                    meta: {title: 'Tasks'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/task/TasksDetails.vue'),
                    // Ensure this component is created
                    name: 'TaskDetails', // A unique name for the route
                    path: '/task/:id', // Dynamic segment to capture the board ID
                    meta: {title: 'Tasks Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/user/Users.vue'),
                    name: USERS,
                    path: 'users',
                    meta: {title: 'Users'},

                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/user/ProfileDetails.vue'),
                    // Ensure this component is created
                    name: 'ProfileDetails', // A unique name for the route
                    path: 'user/:userId/profile/:profileId', // Dynamic segment to capture the board ID
                    meta: {title: 'Profile Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/notification/Notifications.vue'),
                    name: NOTIFICATIONS,
                    path: 'notifications',
                    meta: {title: 'Notifications'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/notification/NotificationsDetails.vue'),
                    // Ensure this component is created
                    name: 'NotificationDetails', // A unique name for the route
                    path: 'notification/:id', // Dynamic segment to capture the board ID
                    meta: {title: 'Notifications Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/poll/Polls.vue'),
                    name: POLLS,
                    path: 'polls',
                    meta: {title: 'polls'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/poll/PollsDetails.vue'),
                    // Ensure this component is created
                    name: 'PollDetails', // A unique name for the route
                    path: 'polls/:id', // Dynamic segment to capture the board ID
                    meta: {title: 'Poll Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/calendar/Calendar.vue'),
                    name: CALENDAR,
                    path: 'calendar',
                    meta: {title: 'Calendar'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/agenda/agenda/AgendaStart.vue'),
                    name: AGENDAS,
                    path: 'agendas',
                    meta: {title: 'Agendas'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/settings/settings.vue'),
                    name: SETTINGS,
                    path: 'settings',
                    meta: {title: 'Settings'},
                },

                // ...rolePermRoutes,

            ],
        component: () => import('@/staff/Main.vue'),
        path: '/',
    },
];

export default staffRoutes;
