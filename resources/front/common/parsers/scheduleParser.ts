
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {meetingParser} from './meetingParser';

export const scheduleParser = object({
    id:string(), //from db
    date:string(),
    start_time:string(),
    end_time:string(),
    status: string(),
    heldstatus: string(),
    meeting_id:object({
        id: string(),
        title: string(),
        conference: string(),
        location: string(),
        description: string(),
        link: string().nullable(),
        status: string(),
        type: string(),
        committee_id: string(),
    }),
    // meeting:meetingParser,
    created_at:string(),
});

export interface ScheduleRequestPayload{ //to db
    date:string,
    start_time:string,
    end_time:string,
    status:string|null
    heldstatus:string|null
    meeting_id:string|null,
}

export interface nonPaginateResponse {
    code: number,
    data: Schedule[],
    message: string
}
export interface singleScheduleResponse { //from backend
    code: number,
    data: Schedule,
    message: string,
}

export type Schedule = output<typeof scheduleParser>;



