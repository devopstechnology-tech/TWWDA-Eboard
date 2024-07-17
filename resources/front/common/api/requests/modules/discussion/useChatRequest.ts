import Qs from 'qs';
import {chatRoute} from '@/common/api/chat_routes';
import useClient from '@/common/api/client';
import {ChatRequestPayload, nonPaginateResponse} from '@/common/parsers/chatParser';


export async function useCreateChatRequest(
    payload: ChatRequestPayload,
    userId: string,
    options?: object, 
):Promise<nonPaginateResponse>{
    const client = useClient();  
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const response = await client.post(chatRoute() + '/'+ userId + '?' + cn,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateChatRequest(
    payload: ChatRequestPayload,
    options?: object, 
):Promise<nonPaginateResponse>{
    const client = useClient(); 
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const response = await client.patch(chatRoute() + '/update/' + payload.id + '?' + cn,{
        json: payload,
    });
    return response.json();
}





