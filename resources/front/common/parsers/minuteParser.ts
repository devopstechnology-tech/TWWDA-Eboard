
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
// import {minuteassigneeParser} from '@/common/parsers/minuteassigneeParser';
// import {SubMinute, subminuteParser} from '@/common/parsers/subminuteParser';

export const minuteRequestParser = object({
    id:string(), //from db
    meeting_id:string(), //from db
    title: string(),
    duration: number(),
    description: string(),
    minute_id: string().nullable(),
    children:array(subminuteParser).nullable(),
    assignees:array(minuteassigneeParser).nullable(),
});

export interface MinuteRequestPayload{ //to db
    meeting_id: string;
    board_id: string | null;
    committee_id: string | null;
    membership_id: string | null;
    // // minutedetails
    minute_id: string | null;
    agenda_id: string;
    detailminute_id: string| null;
    subdetailminute_id: string| null;
    subagenda_id: string| null;
    description: string;
    status: string;
}
export interface MinuteMembersRequestPayload {
    members: string[],
}

export interface SelectedResult {
    id: number,
    name: string,
}
export interface MinuteMemberEditParams {
    id: string;
    members: {
      [x: string]: any;

user: any; id: string; full_name: string;
}[];
}


export interface nonPaginateResponse {
    code: number,
    data: Minute[],
    message: string
}

export type Minute = output<typeof minuteRequestParser>;

// for creating deafault during creation of minutes
export interface DefaultMinute {
    id: string,
    title: string,
    children?: DefaultMinute[],
};



