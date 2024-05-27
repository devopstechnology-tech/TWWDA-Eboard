import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {minutesRoute} from '@/common/api/minute_routes';
import {MinuteRequestPayload, nonPaginateResponse} from '@/common/parsers/minuteParser';
import {Meta} from '@/common/types/types';


export async function useGetMinutesRequest(id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(minutesRoute()+ '/' + id + '?' + cn).json();
}

export async function useCreateMinuteRequest(payload: MinuteRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(minutesRoute() + '/create/' + id,{
        json: payload,
    });
    return response.json();
}
export async function useCreateSubMinuteRequest(payload: MinuteRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(minutesRoute() + '/create/subminute/' + id,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMinuteRequest(payload: MinuteRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(minutesRoute() + '/update/minute/' + id, {
        json: payload,
    }).json();
}

export async function useUpdateSubMinuteRequest(payload: MinuteRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(minutesRoute() + '/update/minute/subminute/' + id, {
        json: payload,
    }).json();
}




