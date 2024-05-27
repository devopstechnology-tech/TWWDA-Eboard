import {object, output, string} from 'zod';

export const optionParser = object({
    id:string(),
    poll_id:string().nullable(),
    title:string(),
    deleted_at:string().nullable(),
    created_at:string().nullable(),
    updated_at:string().nullable(),
});

export type Option = output<typeof optionParser>;
