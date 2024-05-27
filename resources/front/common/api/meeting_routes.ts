import {compile} from 'path-to-regexp';

export const meetingRoute = compile('api/v1/meetings');
export const boardMeetingRoute = compile('api/v1/meetings/board');
export const singleboardMeetingRoute = compile('api/v1/meeting/board');
export const committeeMeetingRoute = compile('api/v1/meetings/committee');
export const singlecommitteeMeetingRoute = compile('api/v1/meeting/committee');
export const meetingMemberRoute = compile('api/v1/meetings/members');


