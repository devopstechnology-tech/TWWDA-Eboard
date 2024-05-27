
import {object, output, string} from 'zod';

export const customUserAssigneeParser = object({
    id:string(),    
    full_name: string(),
});
export const pollassigneeParser = object({
    id:string(),
    poll_id: string().nullable(),
    membership_id: string(),
    user: customUserAssigneeParser,
});


export type PollAssignee = output<typeof pollassigneeParser>;



