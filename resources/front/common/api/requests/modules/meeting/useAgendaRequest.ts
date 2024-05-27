import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import {agendaMemberRoute,agendaRoute} from '@/common/api/agenda_routes';
import useClient from '@/common/api/client';
import {Agenda} from '@/common/parsers/agendaParser';
import {Meta} from '@/common/types/types';

interface AgendaRequestPayload {
    name: string,
    description: string,
    icon: string,
    cover: string,
}
interface AgendaMembersRequestPayload {
    members: string[],
}

interface AgendaMember {
    id: string;
    full_name: string;
  }

interface response {
    code: number,
    data: {
        data: Agenda[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Agenda,
    message: string
}

export async function useCreateAgendaRequest(payload: AgendaRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(agendaRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdateAgendaRequest(payload: AgendaRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(agendaRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useGetMeetingAgendasRequest(id: string): Promise<response> {
    const client = useClient();

    return await client.get(agendaMeetingRoute()+ '/' + id).json();
}
export async function useUpdateAgendaMembersRequest(payload: AgendaMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(agendaMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

// export async function useGetAgendasRequest(options?: object): Promise<response> {
//     const client = useClient();

//     // eslint-disable-next-line @typescript-eslint/ban-ts-comment
//     // @ts-ignore
//     // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
//     return await client.get(agendaRoute()).json();
// }

// export async function useGetSingleAgendaRequest(id: string): Promise<singleresponse> {
//     // console.log('id', id);
//     const client = useClient();
//     const data: singleresponse = await client.get(agendaRoute() + '/' + id).json();
//     return data;
// }

// export async function useDeleteAgendaRequest(id: string): Promise<singleresponse> {
//     // loading.setLoading(true);
//     const client = useClient();
//     // eslint-disable-next-line @typescript-eslint/ban-ts-comment
//     // @ts-ignore
//     const data: singleresponse = await client.delete(agendaRoute() + '/' + id).json();
//     // loading.setLoading(false);
//     return data;
// }




