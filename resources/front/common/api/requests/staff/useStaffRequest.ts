import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {staffStaffRoute, userRoute} from '@/common/api/staff_routes';
import {Staff, UserStaff} from '@/common/parsers/staffParser';
import {nonPaginateResponse} from '@/common/parsers/userParser';
import {Meta} from '@/common/types/types';

interface StaffRequestPayload {
    first: string;
    last: string;
    id_number: string;
    phone: string;
    email: string;
    // department_id: number;
    // pos_account_id: number;
    // image: File;
    // description: null | string;
}

interface response {
    code: number,
    data: {
        data: Staff[],
        meta: Meta
    },
    message: string
}

interface Usersresponse {
    code: number,
    data:  UserStaff[],
    message: string
}

interface singleresponse {
    code: number,
    data: Staff,
    message: string
}

export async function useCreateStaffRequest(payload: StaffRequestPayload) {
    // loading.setLoading(true);
    const client = useClient();

    await client.post(staffStaffRoute(), {
        json: payload,
    }).json();
    notify({
        title: 'Success',
        text: 'Staff Created Successfully',
        type: 'success',
    });
    // loading.setLoading(false);
}

export async function useUpdateStaffRequest(payload: StaffRequestPayload, id: number) {
    // loading.setLoading(true);
    const client = useClient();

    await client.patch(staffStaffRoute() + '/' + id, {
        json: payload,
    }).json();
    // loading.setLoading(false);
}

export async function useGetStaffsRequest(options?: object): Promise<nonPaginateResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(userRoute() + '?' + cn).json();
}

export async function useGetSingleStaffsRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.get(staffStaffRoute() + '/' + id).json();
    // loading.setLoading(false);
    notify({
        title: 'Success',
        text: 'Data Fetched successfully',
        type: 'success',
    });
    return data;
}

export async function useDeleteStaffRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(staffStaffRoute() + '/' + id).json();
    // loading.setLoading(false);
    notify({
        title: 'Success',
        text: 'Data Deleted successfully',
        type: 'info',
    });
    return data;
}
