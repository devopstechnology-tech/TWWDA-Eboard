import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {MembershipsRoute} from '@/common/api/membership_routes';
import {Membership, MembershipRequestPayload, nonPaginateResponse} from '@/common/parsers/membershipParser';
import {Meta} from '@/common/types/types';

export async function useGetMembershipsRequest(
    meeting:string,
    board: string,
    options?: object,
):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(MembershipsRoute()+ '/meeting/' + meeting + '/board/' + board + '?' + cn).json();
}

export async function useCreateMembershipRequest(payload: MembershipRequestPayload,
    meeting:string,
    board: string,
){
    const client = useClient();
    const response = await client.post(MembershipsRoute() + '/create/meeting/' + meeting + '/board/' + board,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMembershipRequest(
    payload: MembershipRequestPayload,
    meeting:string,
    board: string,
) {
    const client = useClient();

    await client.post(MembershipsRoute() + '/update/meeting/' + meeting + '/board/' + board, {
        json: payload,
    }).json();
}




