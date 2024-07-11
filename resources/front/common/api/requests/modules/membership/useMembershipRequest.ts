import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {MembershipsRoute} from '@/common/api/membership_routes';
import {Membership, MemberShipPositionRequestPayload, MembershipRequestPayload, nonPaginateResponse} from '@/common/parsers/membershipParser';
import {Meta} from '@/common/types/types';

export async function useGetMembershipsRequest(
    meeting:string,
    options?: object,
):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(MembershipsRoute()+ '/meeting/' + meeting + '?' + cn).json();
}

export async function useCreateMembershipRequest(payload: MembershipRequestPayload,
    meeting:string,
){
    const client = useClient();
    const response = await client.post(MembershipsRoute() + '/create/meeting/' + meeting,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMembershipRequest(
    payload: MembershipRequestPayload,
    meeting:string,
    schedule: string,
) {
    const client = useClient();

    await client.post(MembershipsRoute() + '/update/meeting/' + meeting + '/schedule/' + schedule, {
        json: payload,
    }).json();
}


export async function useUpdateMemberShipPositionRequest(
    payload: MemberShipPositionRequestPayload, 
    id: string,  
    schedule: string,
) {
    const client = useClient();

    await client.post(MembershipsRoute() + '/update/membership/position/' + id + '/schedule/' + schedule, {
        json: payload,
    }).json();
}



