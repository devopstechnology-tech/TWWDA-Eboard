import {array, boolean, number, object, output, string} from 'zod';

export const meetingParser = object({
    // created_at: string(),
    id: string(),
    title: string(),
    conference: string(),
    location: string(),
    description: string(),
    link: string().nullable(),
    status: string(),
    committee_id: string(),
    //schdeule
    schedule:object({
        type: string(),
        timezone: string(),
        start_time: string(),
        end_time: string(),
    }),
    //agenda
});
export interface MeetingRequestPayload{ //to db
    title: string,
    conference: string,
    location: string,
    description: string,
    link: string | null,
    status: string,
    // committee_id: null,
    // board_id: string,
    //schdeule
    type: string,
    timezone: string,
    start_time: string,
    end_time: string,
}




export interface nonPaginateResponse {
    code: number,
    data: Meeting[],
    message: string
}
export type Meeting = output<typeof meetingParser>;


