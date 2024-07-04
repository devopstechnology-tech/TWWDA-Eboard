
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {permissionParser} from '@/common/parsers/permissionParser';
import {positionParser} from '@/common/parsers/positionParser';
import {userparser} from '@/common/parsers/userParser';
import {profileParser} from './profileParser';

export const membershipRequestParser = object({
    id:string(),
    location:string(),
    meeting_id:string(),
    member_id:string(),
    signature:string(),
    status:string(),
    position_id:string(),
    position:positionParser,
    memberable_id:string(),
    memberable_type:string(),
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
        profile: object({
            id: string(),
            avatar: string(),
            ethnicity: string().nullable(),
            phone: string(),
            idpassportnumber: string(),
            gender_id: string().nullable(),
            address: string().nullable(),
            home_county_id: string().nullable(),
            residence_county_id: string().nullable(),
            city: string().nullable(),
            state: string().nullable(),
            nationality: string().nullable(),
            about: string().nullable(),
            kra_pin: string().nullable(),
            member_cv: string().nullable(),
            establishment: string().nullable(),
            title: string().nullable(),
            appointing_authority: string().nullable(),
            appointment_date: string().nullable(),
            appointment_letter: string().nullable(),
            appointment_end_date: string().nullable(),
            serving_term: string().nullable(),
            current_period: string().nullable(),
            user_id: string(),
            created_at: string(),
            updated_at: string(),
        }),
        type: string(),
    }),   
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

export interface MemberShipPositionRequestPayload{ //to db update mber usr role
    id: string,
    position_id: string,
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




