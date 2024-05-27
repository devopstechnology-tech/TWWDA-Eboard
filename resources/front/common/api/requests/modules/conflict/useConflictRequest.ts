
import Qs from 'qs';
import useClient from '@/common/api/client';
import {conflictRoute} from '@/common/api/conflict_routes';
import {ConflictRequestPayload, nonPaginateResponse} from '@/common/parsers/ConflictParser';

//all conflicts //superadmin
export async function useGetConflictsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(conflictRoute() + '?' + cn).json();
}

//meeting conflicts
export async function useGetMeetingConflictsRequest(meeting_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(conflictRoute()+ '/meeting/' + meeting_id + '?' + cn).json();
}

export async function useCreateMeetingConflictRequest(
    payload: ConflictRequestPayload,
    meetingid: string,
){
    const client = useClient();
    const response = await client.post(conflictRoute() + '/meeting/create/' + meetingid ,{
        json: payload,
    });
    return response.json();
}
export async function useUpdateMeetingConflictRequest(
    payload: ConflictRequestPayload,
    meetingid: string,
){
    const client = useClient();
    const response = await client.patch(conflictRoute() + '/meeting/update/' + meetingid + '/' + payload.conflict_id,{
        json: payload,
    });
    return response.json();
}

