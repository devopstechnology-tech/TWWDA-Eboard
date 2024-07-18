
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {meetingParser} from './meetingParser';
import { positionParser } from './positionParser';

export const scheduleParser = object({
    id:string(), //from db
    date:string(),
    start_time:string(),
    end_time:string(),
    status: string(),
    heldstatus: string(),
    meeting_id:string(),
    meeting:object({
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
    attendances:array(object({
        id:string(),
        location:string(),
        invite_status:string(),
        rsvp_status:string(),
        attendance_status:string(),
        meeting_id:string(),
        membership_id:string(),
        membership:object({
            id:string(),
            location:string(),
            meeting_id:string(),
            member_id:string(),
            signature:string(),
            status:string(),
            position_id:string(),
            position:positionParser,
            memberable_id:string(),
            memberable_type:string(),
            user_id:string(),
            user:object({
                email: string(),
                first: string(),
                full_name: string(),
                id: string(),
                type: string(),
            }),
        }),
    })),
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

export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        schedules: Schedule[];
    };
    message: string;
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



