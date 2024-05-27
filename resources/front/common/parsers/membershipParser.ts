
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {userparser} from '@/common/parsers/userParser';
import { permissionParser } from './permissionParser';

export const membershipRequestParser = object({
    // board_id: string(),
    // memberships:array(object({
    //     id: string(),
    //     full_name: string(),
    // })).nullable(),
    id:string(),
    location:string(),
    meeting_id:string(),
    member_id:string(),
    signature:string(),
    status:string(),
    user_id:string(),
    user:object({
        email: string(),
        first: string(),
        full_name: string(),
        id: string(),
        last: string(),
        other_names: string().nullable(),
        permissions: array(permissionParser).nullable(),
        role: string(),
        type: string(),
    }),
    memberable_id:string(),
    memberable_type:string(),
    attendances:array(object({
        id:string(),
        attendance_status:string(),
        location:string(),
        meeting_id:string(),
        membership_id:string(),
        rsvp_status:string(),
    })),
});

export interface MembershipRequestPayload{ //to db
    board_id: string,
    memberships: string[],
}

//for selcting when filetering users fromdb
export interface SelectedResult {
    id: number,
    name: string,
}

//for editing addingnew users prefil in multiselct

export interface MembershipEditParams {
    memberships: {
      [x: string]: any;
        user: any;
        id: string;
        full_name: string;
    }[];
}
export interface nonPaginateResponse {
    code: number,
    data: Membership[],
    message: string
}

export type Membership = output<typeof membershipRequestParser>;




