import {array, number, object, output, string} from 'zod';
import {permissionParser} from '@/common/parsers/permissionParser';

export const roleParser = object({
    name: string(),
    description: string().nullable(),
    permissions_count: string().nullable(),
    users_count: string(),
    type: string(),
    permissions: array(permissionParser),
    id: string(),
});



export interface RoleRequestPayload {
    name: string,
    id?: string,
}

export interface nonPaginateResponse {
    code: number,
    data: Role[],
    message: string
}

export type Role = output<typeof roleParser>;