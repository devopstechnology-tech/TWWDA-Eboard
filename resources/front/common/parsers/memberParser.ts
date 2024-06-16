
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {userparser} from './userParser';
import { positionParser } from './positionParser';

export const memberParser = object({
    id: string(),
    board_id:string(),
    committee:string(),
    committee_id:string(),
    guest:string(),
    guest_id:string(),
    position_id:string(),
    position:positionParser,
    user:userparser,
    updated_at:string(),
});


export const memberRequestParser = object({
    board_id: string(),
    members:array(object({
        id: string(),
        full_name: string(),
    })).nullable(),
});

export interface MemberRequestPayload{ //to db
    board_id: string,
    members: string[],
}
export interface MemberPositionRequestPayload{ //to db update mber usr role
    id: string,
    position_id: string,
}

//for selcting when filetering users fromdb
export interface SelectedResult {
    id: number,
    name: string,
}


//for editing addingnew users prefil in multiselct

export interface MemberEditParams {
    members: {
      [x: string]: any;
        user: any;
        id: string;
        full_name: string;
    }[];
}
export interface nonPaginateResponse {
    code: number,
    data: Member[],
    message: string
}

export type Member = output<typeof memberParser>;



