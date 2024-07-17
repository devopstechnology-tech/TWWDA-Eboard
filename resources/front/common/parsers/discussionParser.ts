
import {array, object, output, string} from 'zod';
import {dassigneeParser, DiscussionAssignee, discussionassigneeParser} from '@/common/parsers/DiscussionAssigneeParser';
import {chatParser} from './chatParser';

export const discussionParser = object({
    id:string(),    
    topic:string(),
    description:string(),
    closestatus:string(),
    archivestatus:string(),
    created_at:string(),
    author:object({
        email: string(),
        first: string(),
        full_name: string(),
        id: string(),
        last: string(),
    }),
    assignees:array(discussionassigneeParser),
    dassignees:array(dassigneeParser),
    chats:array(chatParser),
});

export interface DiscussionRequestPayload{ //to db
    id:string| null,
    topic:string,
    description:string,
    closestatus:string,
    archivestatus:string,
    message:string|null,
    assignee_sender_id:string|null,
    discussionassignees:DiscussionAssignee[],
}

export interface nonPaginateResponse {
    code: number,
    data: Discussion[],
    message: string
}

export type Discussion = output<typeof discussionParser>;




