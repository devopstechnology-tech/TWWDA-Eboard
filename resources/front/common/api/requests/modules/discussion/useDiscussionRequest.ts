import Qs from 'qs';
import useClient from '@/common/api/client';
import {discussionRoute} from '@/common/api/discussion_routes';
import {DiscussionRequestPayload,nonPaginateResponse} from '@/common/parsers/discussionParser';

//all discussions
export async function useGetUserDiscussionsRequest(user_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(discussionRoute()+'/'+ user_id + '?' + cn).json();
}
export async function useCreateDiscussionRequest(
    payload: DiscussionRequestPayload, 
    userid: string,  
){
    const client = useClient();
    const response = await client.post(discussionRoute() + '/' + userid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateDiscussionRequest(
    payload: DiscussionRequestPayload, 
    userid: string,  
    discussionid:string,
){
    const client = useClient();
    const response = await 
    client.patch(discussionRoute() + '/update/' + userid + '/' + discussionid,{
        json: payload,
    });
    return response.json();
}




