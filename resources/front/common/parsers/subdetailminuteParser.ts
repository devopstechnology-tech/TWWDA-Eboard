
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
// import {minuteassigneeParser} from '@/common/parsers/minuteassigneeParser';
// import {SubMinute, subminuteParser} from '@/common/parsers/subminuteParser';

export const subdetailminuteParser = object({
    id:string(),
    detail_minute_id:string(),
    subagenda_id:string(),
    description:string(),
    status:string(),
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



export type SubdetailMinute = output<typeof subdetailminuteParser>;
