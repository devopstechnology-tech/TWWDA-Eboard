import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {staffPermissionsRoute} from '@/common/api/staff_routes';
import {Permission} from '@/common/parsers/permissionParser';
import {Meta} from '@/common/types/types';

interface response {
    code: number,
    data: {
        data: Permission[],
        meta: Meta
    },
    message: string
}

interface nonPaginatedResponse {
    code: number,
    data: Permission[],
    message: string
}

export async function useGetUnPaginatedPermissionsRequest(options?: object): Promise<nonPaginatedResponse> {
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const data: nonPaginatedResponse = await client.get(staffPermissionsRoute() + '?' + cn).json();
    notify({
        title: 'Success',
        text: 'Data Fetched successfully',
        type: 'success',
    });
    return data;
}

export async function useGetPermissionsRequest(options?: object): Promise<response> {
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const data: response = await client.get(staffPermissionsRoute() + '?' + cn).json();
    notify({
        title: 'Success',
        text: 'Data Fetched successfully',
        type: 'success',
    });
    return data;
}
