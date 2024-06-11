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
    committee_id: string(),
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




export interface nonPaginateResponse {
    code: number,
    data: Meeting[],
    message: string
}
export type Meeting = output<typeof meetingParser>;


