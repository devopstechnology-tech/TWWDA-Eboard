import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {userRoute} from '@/common/api/user_routes';
import {LOCAL_TOKEN} from '@/common/constants/localStorageKeys';
import unwrap from '@/common/parsers/unwrap';
import {AcceptInviteRequestPayload, AuthenticatedUser, authenticatedUserParser, NonPaginateLatestResponse, nonPaginateResponse,singleresponse,UserRequestPayload} from '@/common/parsers/userParser';
import {Meta} from '@/common/types/types';

// SUPERADMIN
export async function useGetUsersRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(userRoute() + '?' + cn).json();
}
export async function useGetLatestUsersRequest(options?: object): Promise<NonPaginateLatestResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(userRoute() + '/latest'+ '?' + cn).json();
}



export async function useGetTrashedUsersRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(userRoute() + '/trashedusers'+ '?' + cn).json();
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
// update via users update
export async function useUpdateUserRoleRequest(payload: UserRequestPayload, userId:string){
    const client = useClient();
    const response = await client.post(userRoute() + '/role/update/' + userId ,{
        json: payload,
    });
    return response.json();
}
export async function useDeleteUserRequest(id: string){
    const client = useClient();
    await client.post(userRoute() + '/delete/' + id);
}
export async function useRestoreDeleteUserRequest(id: string){
    const client = useClient();
    await client.post(userRoute() + '/restore/delete/' + id);
}
export async function useForceDeleteUserRequest(id: string){
    const client = useClient();
    await client.post(userRoute() + '/force/delete/' + id);
}


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
