import {array, number, object, output, string} from 'zod';
import {zonesParser} from '@/common/parsers/zonesParser';

export const modificationParser = object({
    name: string(),
    action: string(),
    description: string().nullable(),
    schedule_id: number(),
    section_id: number(),
    id: number(),
    amount: string(),
    class: array(zonesParser),
});

export type Modification = output<typeof modificationParser>;
