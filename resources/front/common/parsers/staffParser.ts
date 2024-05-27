import {array, boolean, number, object, output, string} from 'zod';

export const staffParser = object({
    // created_at: string(),
    email: string().nullable(),
    description: string().nullable(),
    id_number: string(),
    first: string(),
    id: number(),
    last: string(),
    status: string(),
    image: string(),
    phone: string(),
    permissions: array(string()).nullable(),
    role: string().nullable(),
    // updated_at: string(),
});

export type Staff = output<typeof staffParser>;

export const staffUserParser = object({
    id: number(),
    full_name: string(),
});

export type UserStaff = output<typeof staffUserParser>;

export const registerStaffParser = object({
    // created_at: string(),
    first: string(),
    last: string(),
    email: string().nullable(),
    phone: string().nullable(),
    id_number: string(),
    status: boolean(),
    // updated_at: string(),
});

export type RegisterStaff = output<typeof registerStaffParser>;
