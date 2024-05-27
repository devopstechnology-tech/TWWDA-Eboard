import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {userRoute} from '@/common/api/user_routes';
import {LOCAL_TOKEN} from '@/common/constants/localStorageKeys';
import unwrap from '@/common/parsers/unwrap';
import {AcceptInviteRequestPayload, AuthenticatedUser, authenticatedUserParser, nonPaginateResponse,singleresponse,UserRequestPayload} from '@/common/parsers/userParser';
import {Meta} from '@/common/types/types';

// SUPERADMIN
export async function useGetUsersRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(userRoute() + '?' + cn).json();
}



export async function useCreateUserRequest(payload: UserRequestPayload){
    const client = useClient();
    const response = await client.post(userRoute() + '/create',{
        json: payload,
    });
    return response.json();
}

//update via registaring acceprting
export async function useUpdateUserRequest(payload: AcceptInviteRequestPayload){
    const client = useClient();
    const response = await client.post(userRoute() + '/update/' + payload.id ,{
        json: payload,
    });
    return response.json();
}
// update via self profiel update
export async function useUpdateProfileUserRequest(payload: AcceptInviteRequestPayload, userId:string){
    const client = useClient();
    const response = await client.post(userRoute() + '/update/' + userId ,{
        json: payload,
    });
    return response.json();
}
// export async function useDeleteUserRequest(payload: UserRequestPayload, id: string){
//     const client = useClient();
//     const response = await client.patch(userRoute() + '/delete/' + id ,{
//         json: payload,
//     });
//     return response.json();
// }


// acceprt invitation with otp direct login
export async function useAcceptInviteRequest(
    payload: AcceptInviteRequestPayload):Promise<AuthenticatedUser> {
    const client = useClient();
    const response = await client.post(userRoute() + '/acceptance/' + payload.token, {
        json: payload,
    }).json();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    localStorage.setItem(LOCAL_TOKEN, response.data.token);

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    return unwrap(authenticatedUserParser).parse({data: response.data.user});
}
