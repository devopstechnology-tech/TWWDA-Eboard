import {number, object, output, string} from 'zod';

export const subCountyParser = object({
    // created_at: string(),
    id: number(),
    name: string(),
    // updated_at: string(),
});

export type SubCounty = output<typeof subCountyParser>;
