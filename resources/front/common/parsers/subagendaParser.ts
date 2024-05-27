import {array, number, object, output, string} from 'zod';

export const subagendaParser = object({
    title: string(),
    duration: number(),
    description: string(),
    agenda_id: string(),
    id: string(),
});

export type SubAgenda = output<typeof subagendaParser>;
