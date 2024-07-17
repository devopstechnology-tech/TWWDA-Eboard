
import {array, object, output, string} from 'zod';
import {simpleuserparser} from './userParser';

export const chatParser = object({
    id:string(),
    discussion_id:string(),
    discussion:string(),
    message:string(),
    editstatus:string(),
    file:string(),
    media:string(),
    created_at:string(),
    assignee_sender_id:string(),
    sender:(simpleuserparser),
    assignee_receiver_id:string(),
    receiver:(simpleuserparser),
});

export interface ChatRequestPayload{ //to db
    id:string | null,
    topic:string,
    description:string,
    message:string,
    assignee_sender_id:string,
    discussion_id:string,
    // discussionassignees:DiscussionAssignee[],
}

export interface nonPaginateResponse {
    code: number,
    data: Chat[],
    message: string
}

export type Chat = output<typeof chatParser>;




