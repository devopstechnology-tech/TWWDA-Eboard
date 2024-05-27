import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {discussionMemberRoute,discussionRoute} from '@/common/api/discussion_routes';
import {Discussion} from '@/common/parsers/discussionParser';
import {Meta} from '@/common/types/types';

interface DiscussionRequestPayload {
    name: string,
    description: string,
    icon: string,
    cover: string,
}
interface DiscussionMembersRequestPayload {
    members: string[],
}

interface DiscussionMember {
    id: string;
    full_name: string;
  }

interface response {
    code: number,
    data: {
        data: Discussion[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Discussion,
    message: string
}

export async function useCreateDiscussionRequest(payload: DiscussionRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(discussionRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdateDiscussionRequest(payload: DiscussionRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(discussionRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdateDiscussionMembersRequest(payload: DiscussionMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(discussionMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetDiscussionsRequest(options?: object): Promise<response> {
    const client = useClient();

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(discussionRoute()).json();
}

export async function useGetSingleDiscussionRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(discussionRoute() + '/' + id).json();
    return data;
}

export async function useDeleteDiscussionRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(discussionRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}




