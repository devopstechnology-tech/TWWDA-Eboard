import {array, number, object, output, string} from 'zod';

export const agendaassigneeParser = object({
    id: string(),
    full_name: string(),
});

export type AgendaAssignee = output<typeof agendaassigneeParser>;
