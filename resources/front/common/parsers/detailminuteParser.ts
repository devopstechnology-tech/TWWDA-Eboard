
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import { subdetailminuteParser } from './subdetailminuteParser';
// import {minuteassigneeParser} from '@/common/parsers/minuteassigneeParser';
// import {SubMinute, subminuteParser} from '@/common/parsers/subminuteParser';

export const detailminuteParser = object({
    id:string(),
    minute_id:string(),
    agenda_id:string(),
    description:string(),
    status:string(),
    minute:string(),
    agenda:string(),
    subdetailminutes:array(subdetailminuteParser),
    minutereview:string(),
});

// export interface MinuteRequestPayload{ //to db
//     schedule_id: string;
//     board_id: string | null;
//     committee_id: string | null;
//     membership_id: string | null;
//     // // minutedetails
//     minute_id: string | null;
//     agenda_id: string;
//     detailminute_id: string| null;
//     subdetailminute_id: string| null;
//     subagenda_id: string| null;
//     description: string;
//     status: string;
// }


// for creating deafault during creation of minutes
export interface DefaultMinute {
    id: string,
    title: string,
    children?: DefaultMinute[],
};


export type DetailMinute = output<typeof detailminuteParser>;
