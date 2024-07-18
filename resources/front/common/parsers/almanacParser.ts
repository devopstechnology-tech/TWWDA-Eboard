
import {object, output, string} from 'zod';

export const almanacRequestParser = object({ //from db
    id:string(),
    type:string(),
    purpose:string(),
    start:string(),
    end:string(),
    budget:string(),
    status:string(),
    held:string(),
    created_at:string(),
    updated_at:string(),
});

export interface AlmanacRequestPayload{ //to db
    type:string
    purpose:string
    start:string
    end:string
    budget:string
    status:string
    held:string
    fileupload:File|null
}
export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        almanacs: Almanac[];
    };
    message: string;
}

export interface nonPaginateResponse {
    code: number,
    data: Almanac[],
    message: string
}
export interface singleAlmanacResponse {
    code: number,
    data: Almanac,
    message: string
}

export type Almanac = output<typeof almanacRequestParser>;








