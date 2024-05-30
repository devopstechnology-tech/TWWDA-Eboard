import {Options} from 'ky';
import useClient from '@/common/api/client';
import {authRoute} from '@/common/api/routes';
import {SingleUserResponse} from '@/common/parsers/userParser';

export default async function useCurrentAuthRequest(options: Options = {}){
    const client = useClient(options);
    const response = await client.get(authRoute()).json() as SingleUserResponse;
    return  response.data;
}