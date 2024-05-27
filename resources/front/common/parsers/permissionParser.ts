import {number, object, output, string} from 'zod';

export const permissionParser = object({
    name: string(),
    full_name: string(),
    description: string().nullable(),
    class: string().nullable(),
    action: string(),
    type: string(),
    id: string(),
});

export type Permission = output<typeof permissionParser>;
