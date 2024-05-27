
import {array, nullable, number, object, output, string} from 'zod';

export const conflictRequestParser = object({
    id: string(),
    address: string(),
    nature: string(),
    amount: string(),
    ceased_date: string(),
    remarks: string(),
    conflict_id: string().nullable(),
});

export interface ConflictRequestPayload{ //to db
    address:string,
    nature:string,
    amount:string,
    ceased_date:string,
    remarks:string,
    conflict_id:string| null,
}



export interface nonPaginateResponse {
    code: number,
    data: Conflict[],
    message: string
}

export type Conflict = output<typeof conflictRequestParser>;






