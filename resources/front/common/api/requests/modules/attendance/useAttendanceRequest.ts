import Qs from 'qs';
import {AttendancesRoute} from '@/common/api/attendance_routes';
import useClient from '@/common/api/client';
import {AttendanceRequestPayload, nonPaginateResponse} from '@/common/parsers/attendanceParser';
//all attendances
export async function useGetAttendancesRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(AttendancesRoute() + '?' + cn).json();
}
//meetign attendances
export async function useGetMeetingAttendancesRequest(scheduleId:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(AttendancesRoute()+ '/schedule/' + scheduleId + '?' + cn).json();
}

export async function useCreateAttendanceRequest(
    payload: AttendanceRequestPayload, 
    scheduleId: string, 
){
    const client = useClient();
    const response = await 
    client.post(AttendancesRoute() + '/create/' + scheduleId ,{
        json: payload,
    });
    return response.json();
}
export async function useCreateAttendanceRSVPRequest(
    payload: AttendanceRequestPayload, 
    attendanceid:string,
){
    const client = useClient();
    const response = await 
    client.post(AttendancesRoute() + '/creatersvp/'+ attendanceid,{
        json: payload,
    });
    return response.json();
}
export async function useUpdateAttendanceRSVPRequest(
    payload: AttendanceRequestPayload, 
    attendanceid:string,
){
    const client = useClient();
    const response = await 
    client.post(AttendancesRoute() + '/updatersvp/'+ attendanceid,{
        json: payload,
    });
    return response.json();
}
export async function useSendAttendancesReminder(
    attendanceid:string,
){
    const client = useClient();
    const response = await 
    client.post(AttendancesRoute() + '/reminder/'+ attendanceid);
    return response.json();
}
export async function useUpdateAttendanceSignatureRequest(
    payload: AttendanceRequestPayload, 
    attendanceid:string,
){
    const client = useClient();
    const response = await 
    client.post(AttendancesRoute() + '/signattendance/'+ attendanceid,{
        json: payload,
    });
    return response.json();
}
