
import Qs from 'qs';
import useClient from '@/common/api/client';
import {scheduleRoute} from '@/common/api/schedule_routes';
import {nonPaginateResponse,ScheduleRequestPayload, singleScheduleResponse} from '@/common/parsers/scheduleParser';


//all schedules
export async function useGetSchedulesRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(scheduleRoute() + '?' + cn).json();
}
//meeting schedules
export async function useGetMeetingSchedulesRequest(id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(scheduleRoute()+ '/' + id + '?' + cn).json();
}

export async function useGetMeetingScheduleRequest(id:string):Promise<singleScheduleResponse>{
    const client = useClient();
    return await client.get(scheduleRoute()+ '/' + id).json();
}

export async function useCreateScheduleRequest(payload: ScheduleRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(scheduleRoute() + '/create/' + id,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateScheduleRequest(payload: ScheduleRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(scheduleRoute() + '/update/' + id, {
        json: payload,
    }).json();
}
//close meeting in minutes
export async function useGetCloseMeetingRequest(id: string | null) {
    const client = useClient();

    await client.post(scheduleRoute() + '/close/' + id).json();
}


