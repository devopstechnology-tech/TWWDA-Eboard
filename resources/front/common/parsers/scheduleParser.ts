
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';

export const scheduleParser = object({
    id:string(), //from db
    date:string(),
    start_time:string(),
    end_time:string(),
    status: string(),
    heldstatus: string(),
    meeting_id:string(),
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



