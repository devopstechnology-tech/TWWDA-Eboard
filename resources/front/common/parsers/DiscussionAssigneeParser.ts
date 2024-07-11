
import {object, output, string} from 'zod';

export const customUserAssigneeParser = object({
    id:string(),    
    full_name: string(),
});
export const discussionassigneeParser = object({
    id:string(),
    discussion_id: string().nullable(),
    assignee_id: string(),
    user: customUserAssigneeParser,
});

export type DiscussionAssignee = output<typeof discussionassigneeParser>;

