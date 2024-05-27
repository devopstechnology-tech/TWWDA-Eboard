import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import {meetingAgendasRoute} from '@/common/api/agenda_routes';
import useClient from '@/common/api/client';
import {Agenda, AgendaRequestPayload, nonPaginateResponse} from '@/common/parsers/agendaParser';
import {Meta} from '@/common/types/types';



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
// export async function useCreateAgendaRequest(
//     payload: AgendaRequestPayload) {
//     const client = useClient();
//     const data = new FormData();
//     data.append('name', payload.name);
//     data.append('description', payload.description);
//     data.append('icon', payload.icon);
//     data.append('cover', payload.cover);

//     console.log('we are here payload', data, payload);
//     const response = await client.post(agendaRoute(),{
//         body: data,
//     });
//     return response.json();
// }

// export async function useGetAgendasRequest(options?: object): Promise<response> {
//     const client = useClient();
//     return await client.get(agendaRoute()).json();
// }

// export async function useUpdateAgendaRequest(
//     payload: AgendaRequestPayload, id: string){
//     console.log('payload',payload);
//     const client = useClient();
//     const updatedata = new FormData();
//     updatedata.append('name', payload.name);
//     updatedata.append('description', payload.description);
//     updatedata.append('icon', payload.icon);
//     updatedata.append('cover', payload.cover);

//     console.log('updatedata',updatedata);
//     const response = await client.post(agendaRoute() + '/update/' + id,{
//         body: updatedata,
//     });
//     return response.json();
// }

// //

// export async function useGetSingleAgendaRequest(id: string): Promise<singleresponse> {
//     // console.log('id', id);
//     const client = useClient();
//     const data: singleresponse = await client.get(agendaRoute() + '/' + id).json();
//     return data;
// }
// export async function useUpdateAgendaMembersRequest(payload: AgendaMembersRequestPayload, id: string) {
//     const client = useClient();

//     await client.post(agendaMemberRoute() + '/' + id, {
//         json: payload,
//     }).json();
// }


