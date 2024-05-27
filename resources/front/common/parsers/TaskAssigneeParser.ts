
import {object, output, string} from 'zod';

export const customUserAssigneeParser = object({
    id:string(),    
    full_name: string(),
});
export const taskassigneeParser = object({
    id:string(),
    task_id: string().nullable(),
    membership_id: string(),
    user: customUserAssigneeParser,
});

export type TaskAssignee = output<typeof taskassigneeParser>;