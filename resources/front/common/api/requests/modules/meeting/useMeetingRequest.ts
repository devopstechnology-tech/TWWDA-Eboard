import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {boardMeetingRoute, meetingMemberRoute,meetingRoute, singleboardMeetingRoute} from '@/common/api/meeting_routes';
import {Meeting, MeetingRequestPayload, nonPaginateResponse} from '@/common/parsers/meetingParser';
import {Meta} from '@/common/types/types';

// Define the interface for options
interface Options {
    page: number;
    perPage: number;
    Id: string; // Add committeeId to the Options interface
  }
interface options {
    page: number;
    perPage: number;// Add committeeId to the Options interface
  }

interface MeetingMembersRequestPayload {
    members: string[],
}

interface MeetingMember {
    id: string;
    full_name: string;
  }

interface response {
    code: number,
    data: {
        data: Meeting[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Meeting,
    message: string
}

// Modify useGetMeetingsRequest function to accept committeeId
export async function useGetMeetingsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingRoute()+ '?' + cn).json();
}

// Modify useGetMeetingsRequest function to accept committeeId
export async function useGetBoardMeetingsRequest(options?: Options): Promise<response> {
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    // Include committeeId in the request
    return await client.get(boardMeetingRoute()+ '/' + options.Id).json();
}

export async function useGetSingleBoadMeetingRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(singleboardMeetingRoute() + '/' + id).json();
    return data;
}

export async function useGetSingleMeetingRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(meetingRoute() + '/' + id).json();
    return data;
}

export async function useCreateBoardMeetingRequest(payload: MeetingRequestPayload | FormData) {
    const client = useClient();
    await client.post(boardMeetingRoute(),{
        json: payload,
    }).json();
}

export async function useUpdateBoardMeetingRequest(payload: MeetingRequestPayload | FormData, id: string) {
    const client = useClient();
    await client.patch(boardMeetingRoute() + '/meeting/' + id, {
        json: payload,
    }).json();
}

export async function useCreateMeetingRequest(payload: MeetingRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(meetingRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function usePublishMeetingRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.patch(meetingRoute() + '/publish/' + id).json();
    // loading.setLoading(false);
    return data;
}
export async function useUpdateMeetingRequest(payload: MeetingRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(meetingRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdateMeetingMembersRequest(payload: MeetingMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(meetingMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}





export async function useDeleteMeetingRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(meetingRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}



