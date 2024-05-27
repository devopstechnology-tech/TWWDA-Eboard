import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {meetingguestMemberRoute,meetingguestRoute} from '@/common/api/meetingguest_routes';
import {Meetingguest} from '@/common/parsers/meetingguestParser';
import {Meta} from '@/common/types/types';

interface MeetingguestRequestPayload {
    name: string,
    description: string,
    icon: string,
    cover: string,
}
interface MeetingguestMembersRequestPayload {
    members: string[],
}

interface MeetingguestMember {
    id: string;
    full_name: string;
  }

interface response {
    code: number,
    data: {
        data: Meetingguest[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Meetingguest,
    message: string
}

export async function useCreateMeetingguestRequest(payload: MeetingguestRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(meetingguestRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdateMeetingguestRequest(payload: MeetingguestRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(meetingguestRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdateMeetingguestMembersRequest(payload: MeetingguestMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(meetingguestMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetMeetingguestsRequest(options?: object): Promise<response> {
    const client = useClient();

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingguestRoute()).json();
}

export async function useGetSingleMeetingguestRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(meetingguestRoute() + '/' + id).json();
    return data;
}

export async function useDeleteMeetingguestRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(meetingguestRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}




