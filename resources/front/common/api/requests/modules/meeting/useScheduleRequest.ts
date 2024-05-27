import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {scheduleMemberRoute,scheduleRoute} from '@/common/api/schedule_routes';
import {Schedule} from '@/common/parsers/scheduleParser';
import {Meta} from '@/common/types/types';

interface ScheduleRequestPayload {
    name: string,
    description: string,
    icon: string,
    cover: string,
}
interface ScheduleMembersRequestPayload {
    members: string[],
}

interface ScheduleMember {
    id: string;
    full_name: string;
  }

interface response {
    code: number,
    data: {
        data: Schedule[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Schedule,
    message: string
}

export async function useCreateScheduleRequest(payload: ScheduleRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(scheduleRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdateScheduleRequest(payload: ScheduleRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(scheduleRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdateScheduleMembersRequest(payload: ScheduleMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(scheduleMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetSchedulesRequest(options?: object): Promise<response> {
    const client = useClient();

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(scheduleRoute()).json();
}

export async function useGetSingleScheduleRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(scheduleRoute() + '/' + id).json();
    return data;
}

export async function useDeleteScheduleRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(scheduleRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}




