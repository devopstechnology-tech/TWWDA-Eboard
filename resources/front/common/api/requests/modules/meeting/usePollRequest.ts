import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {pollMemberRoute,pollRoute} from '@/common/api/poll_routes';
import {Poll} from '@/common/parsers/pollParser';
import {Meta} from '@/common/types/types';

interface PollRequestPayload {
    name: string,
    description: string,
    icon: string,
    cover: string,
}
interface PollMembersRequestPayload {
    members: string[],
}

interface PollMember {
    id: string;
    full_name: string;
  }

interface response {
    code: number,
    data: {
        data: Poll[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Poll,
    message: string
}

export async function useCreatePollRequest(payload: PollRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(pollRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdatePollRequest(payload: PollRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(pollRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdatePollMembersRequest(payload: PollMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(pollMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetPollsRequest(options?: object): Promise<response> {
    const client = useClient();

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(pollRoute()).json();
}

export async function useGetSinglePollRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(pollRoute() + '/' + id).json();
    return data;
}

export async function useDeletePollRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(pollRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}
export async function useVotePollRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(pollRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}




