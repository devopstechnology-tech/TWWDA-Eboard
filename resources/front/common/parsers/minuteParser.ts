
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {detailminuteParser} from './detailminuteParser';
import {scheduleParser} from './scheduleParser';
// import {minuteassigneeParser} from '@/common/parsers/minuteassigneeParser';
// import {SubMinute, subminuteParser} from '@/common/parsers/subminuteParser';

export const minuteRequestParser = object({
    id:string(),
    schedule_id:string(),
    schedule:scheduleParser,
    membership_id:string(),
    status:string(),
    author:string(),
    detailminutes:array(detailminuteParser),
    minuteReviews:string(),
});

export interface MinuteRequestPayload{ //to db
    schedule_id: string;
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
export interface nonPaginateResponse {
    code: number,
    data: Minute[],
    message: string
}
export interface singleResponse {
    code: number,
    data: Minute,
    message: string
}



// for creating deafault during creation of minutes
export interface DefaultMinute {
    id: string,
    title: string,
    children?: DefaultMinute[],
};


export type Minute = output<typeof minuteRequestParser>;
