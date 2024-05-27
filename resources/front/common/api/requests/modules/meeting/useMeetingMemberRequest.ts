import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {meetingmemberMemberRoute,meetingmemberRoute} from '@/common/api/meetingmembers_routes';
import {Meetingmember} from '@/common/parsers/meetingmemberParser';
import {Meta} from '@/common/types/types';



export async function useCreateMeetingmemberRequest(payload: MeetingmemberRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(meetingmemberRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdateMeetingmemberRequest(payload: MeetingmemberRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(meetingmemberRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdateMeetingmemberMembersRequest(payload: MeetingmemberMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(meetingmemberMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetMeetingMembersRequest(id:string, options?: object): Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingmemberRoute()+ '/' + id + '?' + cn).json();
}

export async function useGetSingleMeetingmemberRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(meetingmemberRoute() + '/' + id).json();
    return data;
}

export async function useDeleteMeetingmemberRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(meetingmemberRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}




