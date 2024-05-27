import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {pollRoute} from '@/common/api/poll_routes';
import {nonPaginateResponse,PollRequestPayload} from '@/common/parsers/PollParser';
import {Meta} from '@/common/types/types';

//all polls
export async function useGetPollsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(pollRoute()+ '?' + cn).json();
}

export async function useUpdatePollRequest(payload: PollRequestPayload, meetingid: string,  boardid: string){
    const client = useClient();
    const response = await client.post(pollRoute() + '/meeting/update/' + meetingid + '/board/' + boardid,{
        json: payload,
    });
    return response.json();
}

//meetign polls
export async function useGetMeetingPollsRequest(meeting_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(pollRoute()+ '/meeting/' + meeting_id + '?' + cn).json();
}

export async function useCreateMeetingPollRequest(payload: PollRequestPayload, meetingid: string,  boardid: string){
    const client = useClient();
    const response = await client.post(pollRoute() + '/meeting/create/' + meetingid + '/board/' + boardid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMeetingPollRequest(
    payload: PollRequestPayload, 
    meetingid: string,  
    boardid: string ,
    polid:string,
){
    const client = useClient();
    const response = await client.patch(pollRoute() + '/meeting/update/' + meetingid + '/board/' + boardid +'/'+ polid,{
        json: payload,
    });
    return response.json();
}


// export async function useCreateSubPollRequest(payload: PollRequestPayload, id: string){
//     const client = useClient();
//     const response = await client.post(meetingPollsRoute() + '/create/subpoll/' + id,{
//         json: payload,
//     });
//     return response.json();
// }

// export async function useUpdatePollRequest(payload: PollRequestPayload, id: string | null) {
//     const client = useClient();

//     await client.post(meetingPollsRoute() + '/update/poll/' + id, {
//         json: payload,
//     }).json();
// }

// export async function useUpdateSubPollRequest(payload: PollRequestPayload, id: string | null) {
//     const client = useClient();

//     await client.post(meetingPollsRoute() + '/update/poll/subpoll/' + id, {
//         json: payload,
//     }).json();
// }





