
import {array, nullable, number, object, output, string} from 'zod';

export const positionParser = object({
    id:string(),
    name:string(),
    description: string(),
    active: string(),
    created_at:string(),
});

export interface PositionRequestPayload{ //to db
    id:string,
    name:string,
    description:string,
    active:string|null
}

export interface nonPaginateResponse {
    code: number,
    data: Position[],
    message: string
}
export interface singlePositionResponse { //from backend
    code: number,
    data: Position,
    message: string,
}

export type Position = output<typeof positionParser>;




