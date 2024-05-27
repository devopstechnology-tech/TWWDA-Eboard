
import {array, nullable, number, object, output, string} from 'zod';
import {Option,optionParser} from '@/common/parsers/optionParser';
import {PollAssignee, pollassigneeParser} from '@/common/parsers/pollassigneeParser';

export const pollParser = object({
    id:string(),
    meeting_id:string().nullable(),
    board_id:string().nullable(),
    committee_id:string().nullable(),
    question:string(),
    description:string(),
    questionoptiontype:string(),
    optionstatus:string(),
    options:array(optionParser),
    duedate:string(),
    assigneetype:string(),
    assigneestatus:string(),
    pollassignees:array(pollassigneeParser),
    status:string(),
});

export interface PollRequestPayload{ //to db
    meeting_id:string| null,
    board_id:string| null,
    committee_id:string| null,
    question:string,
    description:string,
    questionoptiontype:string,
    optionstatus:string,
    options:Option[],
    duedate:string,
    assigneetype:string,
    assigneestatus:string,
    pollassignees:PollAssignee[],
    status:string,
}


export interface PollMembersRequestPayload {
    members: string[],
}

export interface SelectedResult {
    id: number,
    name: string,
}
export interface PollMemberEditParams {
    id: string;
    members: {
      [x: string]: any;

user: any; id: string; full_name: string;
}[];
}

export interface nonPaginateResponse {
    code: number,
    data: Poll[],
    message: string
}

export type Poll = output<typeof pollParser>;




