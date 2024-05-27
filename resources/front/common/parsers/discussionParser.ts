import {array, boolean, number, object, output, string} from 'zod';

export const discussionParser = object({
    // created_at: string(),
    id: string(),
    name: string(),
    description: string(),
    owner_id: string(),
    icon: string(),
    owner: string(),
    cover: string(),
    status: string(),
    members: array(object({
        id: string(),
        full_name: string(),
    })),
});

export type Discussion = output<typeof discussionParser>;
export const createDiscussionParser = object({
    // created_at: string(),
    name: string(),
    description: string(),
    icon: string(),
    // cover: string(),
    status: string(),
    // updated_at: string(),
});

export type CreateDiscussion = output<typeof createDiscussionParser>;



