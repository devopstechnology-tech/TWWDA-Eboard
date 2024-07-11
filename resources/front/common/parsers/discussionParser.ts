
import {array, object, output, string} from 'zod';
import {DiscussionAssignee, discussionassigneeParser} from '@/common/parsers/DiscussionAssigneeParser';

export const discussionParser = object({
    id:string(),    
    topic:string(),
    description:string(),
    closestatus:string(),
    archivestatus:string(),
    assigneetype:string(),
    assigneestatus:string(),
    discussionassignees:array(discussionassigneeParser),
});

export interface DiscussionRequestPayload{ //to db
    id:string| null,
    topic:string,
    description:string,
    closestatus:string,
    archivestatus:string,
    assigneetype:string,
    assigneestatus:string,
    discussionassignees:DiscussionAssignee[],
}

export interface nonPaginateResponse {
    code: number,
    data: Discussion[],
    message: string
}

export type Discussion = output<typeof discussionParser>;




