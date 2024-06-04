import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import {meetingAgendasRoute} from '@/common/api/agenda_routes';
import useClient from '@/common/api/client';
import {Agenda, AgendaRequestPayload, nonPaginateResponse} from '@/common/parsers/agendaParser';
import {Meta} from '@/common/types/types';



export async function fetchlatestMeetingAgendas(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingAgendasRoute()+ '/previous/'+ '?' + cn).json();
}
export async function agendasSaveImportedMeetingAgendas(
    oldmeetingid:string, newmeetingid:string):Promise<nonPaginateResponse>{
    const client = useClient();
    return await client.get(meetingAgendasRoute()+ '/previous/accept/'
    + oldmeetingid + '/'+ newmeetingid).json();
}
export async function useGetMeetingAgendasRequest(id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingAgendasRoute()+ '/' + id + '?' + cn).json();
}

export async function useCreateAgendaRequest(payload: AgendaRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(meetingAgendasRoute() + '/create/' + id,{
        json: payload,
    });
    return response.json();
}
export async function useCreateSubAgendaRequest(payload: AgendaRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(meetingAgendasRoute() + '/create/subagenda/' + id,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateAgendaRequest(payload: AgendaRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(meetingAgendasRoute() + '/update/agenda/' + id, {
        json: payload,
    }).json();
}

export async function useUpdateSubAgendaRequest(payload: AgendaRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(meetingAgendasRoute() + '/update/agenda/subagenda/' + id, {
        json: payload,
    }).json();
}
export async function useDeleteSubAgendaRequest(id: string) {
    const client = useClient();

    await client.post(meetingAgendasRoute() + '/delete/agenda/subagenda/' + id).json();
}
export async function useDeleteAgendaRequest(id: string) {
    const client = useClient();

    await client.post(meetingAgendasRoute() + '/delete/agenda/' + id).json();
}