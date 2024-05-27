
import {object, output, string} from 'zod';

export const notificationRequestParser = object({
    id: string(),
});

export interface NotificationRequestPayload{ //to db
    id:string,
}


export interface nonPaginateResponse {
    code: number,
    data: Notification[],
    message: string
}

export type Notification = output<typeof notificationRequestParser>;







