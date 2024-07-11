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
                props: (route) => (
                    {token: route.query.token}
                ),
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
                    meta: {title: 'Board Media Details'},
                },
                
                //board meeting
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/board/BoardMeetingDetails.vue'),
                    // Ensure this component is created
                    name: 'BoardMeetingDetails', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/schedule/:scheduleId', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Board Meeting Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/board/includes/Minute.vue'),
                    // Ensure this component is created
                    name: 'BoardMeetingMinutes', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/schedule/:scheduleId/minutes', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Board Meeting Minutes Details'},
                    props: route => ({
                        boardId: route.params.boardId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        defaultMinutes: route.query.defaultMinutes === 'true',  // Interpret as boolean
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/board/includes/MinuteApproval.vue'),
                    // Ensure this component is created
                    name: 'BoardMinuteApproval', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/schedule/:scheduleId/minutes/:minutesId', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Minute Approval By Board/Chaiman'},
                    props: route => ({
                        boardId: route.params.boardId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        minutesId: route.params.minutesId,  // Interpret as boolean
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },
               
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/board/includes/minute/Minutepdf.vue'),
                    // Ensure this component is created
                    name: 'MinuteView', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/schedule/:scheduleId/minutes/:minutesId/pdf', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Minute View'},
                    props: route => ({
                        boardId: route.params.boardId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        minutesId: route.params.minutesId,  // Interpret as boolean
                        // props: (route: { query: { content: unknown; }; }) => ({content: route.query.content}),
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/board/includes/Signature.vue'),
                    // Ensure this component is created
                    name: 'SignatureAttendance', // A unique name for the route
                    path: '/board/:boardId/meeting/:meetingId/schedule/:scheduleId/attendee/:attendeeId/:mediaId', // Dynamic segment to capture the board ID & meting id
                    meta: {title: 'Attendance Signature'},
                    props: route => ({
                        boardId: route.params.boardId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        attendeeId: route.params.attendeeId,
                        mediaId: route.params.mediaId,
                    }),
                },
               


                //committee
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/committee/CommitteeDetail.vue'),
                    // Ensure this component is created
                    name: 'CommitteeDetails', // A unique name for the route
                    path: 'committee/:committeeId', // Dynamic segment to capture the board ID
                    meta: {title: 'Committee Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/committee/includes/document/document.vue'),
                    // Ensure this component is created
                    name: 'CommitteeMediaDetails', // A unique name for the route
                    path: '/committee/:committeeId/folder/:folderId/media/:mediaId', // Dynamic segment to capture the committee ID
                    meta: {title: 'Committee Media Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/committee/includes/MinuteApproval.vue'),
                    // Ensure this component is created
                    name: 'CommitteeMinuteApproval', // A unique name for the route
                    path: '/committee/:committeeId/meeting/:meetingId/schedule/:scheduleId/minutes/:minutesId', // Dynamic segment to capture the committee ID & meting id
                    meta: {title: 'Minute Approval By Committee/Chaiman'},
                    props: route => ({
                        committeeId: route.params.committeeId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        minutesId: route.params.minutesId,  // Interpret as boolean
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },

                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/committee/CommitteeMeetingDetails.vue'),
                    // Ensure this component is created
                    name: 'CommitteeMeetingDetails', // A unique name for the route
                    path: '/committee/:committeeId/meeting/:meetingId/schedule/:scheduleId', // Dynamic segment to capture the committee ID & meting id
                    meta: {title: 'Committee Meeting Details'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/committee/includes/Minute.vue'),
                    // Ensure this component is created
                    name: 'CommitteeMeetingMinutes', // A unique name for the route
                    path: '/committee/:committeeId/meeting/:meetingId/schedule/:scheduleId/minutes', // Dynamic segment to capture the committee ID & meting id
                    meta: {title: 'Committee Meeting Minutes Details'},
                    props: route => ({
                        committeeId: route.params.committeeId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        defaultMinutes: route.query.defaultMinutes === 'true',  // Interpret as boolean
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },
                
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/committee/includes/minute/Minutepdf.vue'),
                    // Ensure this component is created
                    name: 'MinuteView', // A unique name for the route
                    path: '/committee/:committeeId/meeting/:meetingId/schedule/:scheduleId/minutes/:minutesId/pdf', // Dynamic segment to capture the committee ID & meting id
                    meta: {title: 'Minute View'},
                    props: route => ({
                        committeeId: route.params.committeeId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        minutesId: route.params.minutesId,  // Interpret as boolean
                        // props: (route: { query: { content: unknown; }; }) => ({content: route.query.content}),
                        // otherParam: route.query.otherParam  // Pass other parameters as needed
                    }),
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/committee/includes/Signature.vue'),
                    // Ensure this component is created
                    name: 'SignatureAttendance', // A unique name for the route
                    path: '/committee/:committeeId/meeting/:meetingId/schedule/:scheduleId/attendee/:attendeeId/:mediaId', // Dynamic segment to capture the committee ID & meting id
                    meta: {title: 'Attendance Signature'},
                    props: route => ({
                        committeeId: route.params.committeeId,
                        meetingId: route.params.meetingId,
                        scheduleId: route.params.scheduleId,
                        attendeeId: route.params.attendeeId,
                        mediaId: route.params.mediaId,
                    }),
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/meeting/committee/includes/document/document.vue'),
                    // Ensure this component is created
                    name: 'MeetingMediaDetails', // A unique name for the route
                    path: '/committee/:committeeId/meeting/:meetingId/folder/:folderId/media/:mediaId', // Dynamic segment to capture the committee ID
                    meta: {title: 'Media Details'},
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
                    component: () => import('@/staff/pages/secure/almanac/Almanac.vue'),
                    name: ALMANAC,
                    path: 'almanac',
                    meta: {title: 'Almanac'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/discussion/discussions.vue'),
                    name: DISCUSSIONS,
                    path: 'discussions',
                    meta: {title: 'Discussions'},
                },
                {
                    beforeEnter: requireStaffAuthentication,
                    component: () => import('@/staff/pages/secure/discussion/discussionDetails.vue'),
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
