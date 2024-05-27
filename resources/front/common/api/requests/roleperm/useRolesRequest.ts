import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {attachPermissionFromRole, detachPermissionFromRole, staffRolesRoute} from '@/common/api/staff_routes';
import {Role, RoleRequestPayload} from '@/common/parsers/roleParser';
import {Meta} from '@/common/types/types';

interface response {
    code: number,
    data: {
        data: Role[],
        meta: Meta
    },
    message: string
}

export async function useGetRolesRequest(options?: object): Promise<response> {
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const data: response = await client.get(staffRolesRoute() + '?' + cn).json();
    notify({
        title: 'Success',
        text: 'Data Fetched successfully',
        type: 'success',
    });
    return data;
}

export async function useDeleteRoleRequest(id: number) {
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    await client.delete(staffRolesRoute() + '/' + id).json();
    notify({
        title: 'Success',
        text: 'Data Deleted successfully',
        type: 'success',
    });
}

export async function useCreateRoleRequest(payload: RoleRequestPayload) {
    const client = useClient();

    await client.post(staffRolesRoute(), {
        json: payload,
    }).json();
    notify({
        title: 'Success',
        text: 'Role Created Successfully',
        type: 'success',
    });
}

export async function useUpdateRoleRequest(payload: RoleRequestPayload, id: number) {
    const client = useClient();

    await client.put(staffRolesRoute() + '/' + id, {
        json: payload,
    }).json();
    notify({
        title: 'Success',
        text: 'Role Updated Successfully',
        type: 'success',
    });
}

export async function useDetachPermissionFromRoleRequest(
    role_id: number, permission_id: number, options?: object): Promise<response> {
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const data: response = await client.post(detachPermissionFromRole({
        roleId: role_id,
        permissionId: permission_id,
    }) + '?' + cn).json();
    notify({
        title: 'Success',
        text: 'Data Fetched successfully',
        type: 'success',
    });
    return data;
}

export async function useAttachPermissionToRoleRequest(
    role_id: number, permission_id: number, options?: object): Promise<response> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    const data: response = await client.post(attachPermissionFromRole({
        roleId: role_id,
        permissionId: permission_id,
    }) + '?' + cn).json();
    // loading.setLoading(false);
    notify({
        title: 'Success',
        text: 'Data Fetched successfully',
        type: 'success',
    });
    return data;
}
