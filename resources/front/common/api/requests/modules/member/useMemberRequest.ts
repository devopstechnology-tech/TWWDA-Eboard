import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {boardMembersRoute} from '@/common/api/member_routes';
import {Member, MemberRequestPayload, MemberPositionRequestPayload, nonPaginateResponse} from '@/common/parsers/memberParser';
import {Meta} from '@/common/types/types';

//get board memmbers
export async function useGetBoardMembersRequest(id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(boardMembersRoute()+ '/' + id + '?' + cn).json();
}

export async function useCreateMemberRequest(payload: MemberRequestPayload, id: string){
    const client = useClient();
    const response = await client.post(boardMembersRoute() + '/create/' + id,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMemberRequest(payload: MemberRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(boardMembersRoute() + '/update/members/' + id, {
        json: payload,
    }).json();
}
export async function useUpdateMemberPositionRequest(payload: MemberPositionRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(boardMembersRoute() + '/update/member/position/' + id, {
        json: payload,
    }).json();
}



