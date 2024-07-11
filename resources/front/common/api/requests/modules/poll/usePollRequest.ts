import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {pollRoute} from '@/common/api/poll_routes';
import {nonPaginateResponse,PollRequestPayload} from '@/common/parsers/PollParser';

//all polls
export async function useGetPollsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(pollRoute() + '?' + cn).json();
}
//board polls
export async function useGetBoardPollsRequest(board_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(pollRoute()+ '/board/' + board_id + '?' + cn).json();
}

export async function useCreateBoardPollRequest(
    payload: PollRequestPayload, 
    boardid: string,
){
    const client = useClient();
    const response = await client.post(pollRoute() + '/board/create/' + boardid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateBoardPollRequest(
    payload: PollRequestPayload,  
    pollid:string,
){
    const client = useClient();
    const response = await 
    client.patch(pollRoute() + '/board/update/'+ pollid,{
        json: payload,
    });
    return response.json();
}

//committee polls
export async function useGetCommitteePollsRequest(
    committee_id:string, 
    options?: object,
):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(pollRoute()+ '/committee/' + committee_id + '?' + cn).json();
}

export async function useCreateCommitteePollRequest(
    payload: PollRequestPayload, 
    committeeid: string,
){
    const client = useClient();
    const response = await client.post(pollRoute() + '/committee/create/' + committeeid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateCommitteePollRequest(
    payload: PollRequestPayload,  
    pollid:string,
){
    const client = useClient();
    const response = await 
    client.patch(pollRoute() + '/committee/update/'+ pollid,{
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

export async function useCreateMeetingPollRequest(payload: PollRequestPayload, meetingid: string){
    const client = useClient();
    const response = await client.post(pollRoute() + '/meeting/create/' + meetingid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMeetingPollRequest(
    payload: PollRequestPayload, 
    meetingid: string,  
    boardid: string, 
    pollid:string,
){
    const client = useClient();
    const response = await 
    client.patch(pollRoute() + '/meeting/update/' + meetingid +'/' + pollid,{
        json: payload,
    });
    return response.json();
}
export async function useUpdatePollRequest(payload: PollRequestPayload, meetingid: string){
    const client = useClient();
    const response = await client.patch(pollRoute() + '/meeting/update/' + meetingid ,{
        json: payload,
    });
    return response.json();
}




