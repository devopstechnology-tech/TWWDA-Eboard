
import {object, output, string} from 'zod';

export const customUserAssigneeParser = object({
    id:string(),    
    full_name: string(),
});
export const discussionassigneeParser = object({
    id:string(),
    discussion_id: string().nullable(),
    assignee_id: string(),
    user_id: string(),
    user: customUserAssigneeParser,
    assignable: object({
        type:string(),
        details: object({
            id:string(),
            board_id:string(),
            committee_id:string(),
            guest_id:string(),
            memberable_id:string(),
            memberable_type:string(),
            position_id:string(),
            user_id:string(),
            deleted_at:string(),
            updated_at:string(),
            created_at:string(),
        }),
    }),
});
export const dassigneeParser = object({
    id:string(),
    class: string().nullable(),
    name: string(),
});

export type DAssignee = output<typeof dassigneeParser>;

export type DiscussionAssignee = output<typeof discussionassigneeParser>;

