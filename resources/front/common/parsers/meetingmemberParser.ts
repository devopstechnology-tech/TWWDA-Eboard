import {array, boolean, number, object, output, string} from 'zod';

export const meetingmemberParser = object({
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

export type Meetingmember = output<typeof meetingmemberParser>;
export const createMeetingmemberParser = object({
    // created_at: string(),
    name: string(),
    description: string(),
    icon: string(),
    // cover: string(),
    status: string(),
    // updated_at: string(),
});


export interface nonPaginateResponse {
    code: number,
    data: Meetinmember[],
    message: string
}

export type CreateMeetingmember = output<typeof createMeetingmemberParser>;



