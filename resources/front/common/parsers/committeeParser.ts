
import {array, nullable, object, output, string} from 'zod';

export const committeeRequestParser = object({ //from db    
    id:string(),
    name:string(),
    description:string(),
    owner_id:string(),
    owner:string(),
    icon:string(),
    cover:string(),
    status:string(),
    members: array(object({
        id: string(),
        full_name: string(),
    })),
    // folders:string(),
    committeeable:string(),
});
export interface nonPaginateResponse {
    code: number,
    data: Committee[],
    message: string
}
export interface singleCommitteeResponse {
    code: number,
    data: Committee,
    message: string
}


export interface CommitteeRequestPayload{ //to db
    name: string,
    description: string,
    icon: File | string,
    cover: File | string,
}
export interface CommitteeMembersRequestPayload {
    members: string[],
}

export interface CommitteeMember {
    id: string;
    full_name: string;
  }

export interface SelectedResult {
    id: number,
    name: string,
}
export interface CommitteeMemberEditParams {
    id: string;
    members: {
      [x: string]: any;
        user: any; id: string;
        full_name: string;
    }[];
}
export type Committee = output<typeof committeeRequestParser>;


