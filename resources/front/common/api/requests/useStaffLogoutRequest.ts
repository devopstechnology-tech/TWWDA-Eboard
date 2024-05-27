import {Options} from 'ky';
import useClient from '@/common/api/client';
import {staffLogoutRoute} from '@/common/api/staff_routes';

export default async function useStaffLogoutRequest(options: Options = {}): Promise<void> {
    const client = useClient(options);

    await client.post(staffLogoutRoute()).json();
}
