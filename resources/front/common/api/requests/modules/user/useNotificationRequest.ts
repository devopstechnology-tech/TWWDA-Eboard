import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {notificationRoute} from '@/common/api/notification_routes'; 
import {nonPaginateResponse,
    NotificationRequestPayload,
} from '@/common/parsers/NotificationParser';

// SUPERADMIN
export async function useGetAllNotificationsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(notificationRoute() + '?' + cn).json();
}
export async function useGetNotificationsRequest(userId:string,options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(notificationRoute() + '/'+ userId + '?' + cn).json();
}

//update via notification 
export async function useUpdateNotificationRequest(payload: NotificationRequestPayload){
    const client = useClient();
    const response = await client.post(notificationRoute() + '/update/' + payload.id ,{
        json: payload,
    });
    return response.json();
}


