
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {detailminuteParser} from './detailminuteParser';
import {scheduleParser} from './scheduleParser';
import { positionParser } from './positionParser';
import { meetingParser } from './meetingParser';
// import {minuteassigneeParser} from '@/common/parsers/minuteassigneeParser';
// import {SubMinute, subminuteParser} from '@/common/parsers/subminuteParser';

export const minuteRequestParser = object({
    id:string(),
    schedule_id:string(),
    schedule:scheduleParser,
    membership_id:string(),
    approvalstatus:string(),
    status:string(),
    signatures:string(),
    author:string(),
    detailminutes:array(detailminuteParser),    
    minuteReviews:string(),
    meeting_id:string(),
    meeting:meetingParser,
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
});

export interface MinuteRequestPayload{ //to db
    schedule_id: string;
    board_id: string | null;
    committee_id: string | null;
    membership_id: string | null;
    // // minutedetails
    minute_id: string | null;
    agenda_id: string;
    detailminute_id: string| null;
    subdetailminute_id: string| null;
    subagenda_id: string| null;
    description: string;
    approvalstatus: string|null;
    status: string|null;
    signatures: string|null;
}
export interface nonPaginateResponse {
    code: number,
    data: Minute[],
    message: string
}
export interface singleResponse {
    code: number,
    data: Minute,
    message: string
}



// for creating deafault during creation of minutes
export interface DefaultMinute {
    id: string,
    title: string,
    children?: DefaultMinute[],
};


export type Minute = output<typeof minuteRequestParser>;
