
import {array, nullable, object, output, string} from 'zod';

export const boardRequestParser = object({ //from db
    id: string(),
    name: string(),
    description: string(),
    owner_id: string(),
    icon: string(),
    owner: string(),
    cover: string(), // Assume cover is a string representing file path
    status: string(),
    members: array(object({
        id: string(),
        full_name: string(),
    })),
});
export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        boards: Board[];
    };
    message: string;
}

export interface nonPaginateResponse {
    code: number,
    data: Board[],
    message: string
}
export interface singleBoardResponse {
    code: number,
    data: Board,
    message: string
}



export interface BoardRequestPayload{ //to db
    name: string,
    description: string,
    icon: File | string,
    cover: File | string,
}
export interface BoardMembersRequestPayload {
    members: string[],
}

export interface BoardMember {
    id: string;
    full_name: string;
  }

export interface SelectedResult {
    id: number,
    name: string,
}
export interface BoardMemberEditParams {
    id: string;
    members: {
      [x: string]: any;
        user: any; id: string;
        full_name: string;
    }[];
}
export type Board = output<typeof boardRequestParser>;
