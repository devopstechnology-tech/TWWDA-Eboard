
import {array, object, output, string} from 'zod';
import {AttendanceAssignee, attendanceassigneeParser} from '@/common/parsers/AttendanceAssigneeParser';

export const attendanceParser = object({
    id:string(),
    location:string(),
    rsvp_status:string(),
    attendance_status:string(),
    meeting_id:string(),
    membership_id:string(),
    membership:string(),
    meeting:string(),
});

export interface AttendanceRequestPayload{ //to db
    id:string,
    location:string|null,
    rsvp_status:string|null,
    attendance_status:string|null,
    meeting_id:string|null,
    membership_id:string|null,
    membership:string|null,
    meeting:string|null,
}


export interface nonPaginateResponse {
    code: number,
    data: Attendance[],
    message: string
}

export type Attendance = output<typeof attendanceParser>;




