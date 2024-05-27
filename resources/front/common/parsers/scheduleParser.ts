import {array, boolean, number, object, output, string} from 'zod';

export const scheduleParser = object({
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

export type Schedule = output<typeof scheduleParser>;
export const createScheduleParser = object({
    // created_at: string(),
    name: string(),
    description: string(),
    icon: string(),
    // cover: string(),
    status: string(),
    // updated_at: string(),
});

export type CreateSchedule = output<typeof createScheduleParser>;



