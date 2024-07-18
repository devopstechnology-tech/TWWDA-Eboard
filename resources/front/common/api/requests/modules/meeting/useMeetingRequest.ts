import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {boardMeetingRoute, committeeMeetingRoute, meetingMemberRoute,meetingRoute, singleboardMeetingRoute, singlecommitteeMeetingRoute} from '@/common/api/meeting_routes';
import {MeetingMembersRequestPayload, MeetingRequestPayload, NonPaginateLatestResponse, nonPaginateResponse, singleresponse} from '@/common/parsers/meetingParser';
import {response} from '@/common/types/types';

///board
export async function useGetBoardMeetingsRequest(
    id:string, 
    options?: object,
): Promise<nonPaginateResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(boardMeetingRoute()+ '/'+ id +'?' + cn).json();
}

export async function useGetLatestMeetingsRequest(options?: object): Promise<NonPaginateLatestResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingRoute() + '/latest'+ '?' + cn).json();
}


export async function useGetSingleBoardMeetingRequest(id: string): 
Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(singleboardMeetingRoute() + '/' + id).json();
    return data;
}

//committee
export async function useGetCommitteeMeetingsRequest(
    id:string, 
    options?: object,
): Promise<nonPaginateResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(committeeMeetingRoute()+ '/'+ id +'?' + cn).json();
}
export async function useGetSingleCommitteeMeetingRequest(id: string): 
Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(singlecommitteeMeetingRoute() + '/' + id).json();
    return data;
}



//universal
export async function useUpdateMeetingMembersRequest(payload: MeetingMembersRequestPayload, id: string) {
    const client = useClient();
    await client.post(meetingMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetMeetingsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(meetingRoute()+ '?' + cn).json();
}
export async function useGetSingleMeetingRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(meetingRoute() + '/' + id).json();
    return data;
}


export async function useCreateMeetingRequest(payload: MeetingRequestPayload | FormData) {
    const client = useClient();
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);
    const response = await client.post(meetingRoute(), {
        headers,
        body,
    });
    return response.json();
}
export async function useUpdateMeetingRequest(payload: MeetingRequestPayload | FormData, id: string) {
    const client = useClient();
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);
    const response = await client.patch(meetingRoute() + '/' + id, {
        headers,
        body,
    });
    return response.json();
}
export async function usePublishMeetingRequest(
    id: string,
): Promise<singleresponse> {
    const client = useClient();
    const data: singleresponse = await client.patch(meetingRoute() + '/publish/' + id).json();
    return data;
}
export async function useDeleteMeetingRequest(id: string): Promise<singleresponse> {
    const client = useClient();
    const data: singleresponse = await client.delete(meetingRoute() + '/' + id).json();
    return data;
}

