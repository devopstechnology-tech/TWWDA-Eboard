
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
    votes:array(object({
        id:string(),
        assignee_poll_id:string(),
        created_at:string(),
        option_id:string(),
        status:string(),
        date:string(),
    })),
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
export interface PollVoteRequestPayload{ //to db
    poll_id:string,
    poll_assignee_id:string,
    selectedOption:string,
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
export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        polls: Poll[];
    };
    message: string;
}
export interface nonPaginateResponse {
    code: number,
    data: Poll[],
    message: string
}

export type Poll = output<typeof pollParser>;




