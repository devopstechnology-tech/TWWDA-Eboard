import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import {AgendasRoute} from '@/common/api/agenda_routes';
import useClient from '@/common/api/client';
import {Agenda, AgendaRequestPayload, nonPaginateResponse} from '@/common/parsers/agendaParser';
import {Meta} from '@/common/types/types';


export async function fetchlatestMeetingScheduleAgendas(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(AgendasRoute()+ '/previous/'+ '?' + cn).json();
}
export async function agendasSaveImportedMeetingScheduleAgendas(
    oldMeetingScheduleid:string, newMeetingScheduleid:string):Promise<nonPaginateResponse>{
    const client = useClient();
    return await client.get(AgendasRoute()+ '/previous/accept/'
    + oldMeetingScheduleid + '/'+ newMeetingScheduleid).json();
}
export async function useGetMeetingScheduleAgendasRequest(id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(AgendasRoute()+ '/' + id + '?' + cn).json();
}

export async function useCreateAgendaRequest(payload: AgendaRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(AgendasRoute() + '/create/' + id,{
        json: payload,
    });
    return response.json();
}
export async function useCreateSubAgendaRequest(payload: AgendaRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(AgendasRoute() + '/create/subagenda/' + id,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateAgendaRequest(payload: AgendaRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(AgendasRoute() + '/update/agenda/' + id, {
        json: payload,
    }).json();
}

export async function useUpdateSubAgendaRequest(payload: AgendaRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(AgendasRoute() + '/update/agenda/subagenda/' + id, {
        json: payload,
    }).json();
}
export async function useDeleteSubAgendaRequest(id: string) {
    const client = useClient();

    await client.post(AgendasRoute() + '/delete/agenda/subagenda/' + id).json();
}
export async function useDeleteAgendaRequest(id: string) {
    const client = useClient();

    await client.post(AgendasRoute() + '/delete/agenda/' + id).json();
}

