import {array, boolean, number, object, output, string} from 'zod';
import {Schedule, scheduleParser} from './scheduleParser';

export const meetingParser = object({
    // created_at: string(),
    id: string(),
    title: string(),
    conference: string(),
    location: string(),
    description: string(),
    link: string().nullable(),
    status: string(),
    type: string(),
    committee_id: string().nullable(),
    board_id: string().nullable(),
    meetingable: string(),
    //schdeule
    schedules:array(scheduleParser),
});
export interface MeetingRequestPayload{ //to db
    title: string,
    conference: string,
    location: string,
    description: string,
    link: string | null,
    status: string,
    type: string,
    schedules:Schedule[],
}


export interface MeetingMembersRequestPayload {
    members: string[],
}

// export interface response {
//     code: number,
//     data: {
//         data: Meeting[],
//         meta: Meta
//     },
//     message: string
// }

export interface singleresponse {
    code: number,
    data: Meeting,
    message: string
}

export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        meetings: Meeting[];
    };
    message: string;
}
export interface nonPaginateResponse {
    code: number,
    data: Meeting[],
    message: string
}
export type Meeting = output<typeof meetingParser>;


