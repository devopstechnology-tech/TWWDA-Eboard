import {array, object, output, string} from 'zod';
import {profileParser} from '@/common/parsers//profileParser';
import {permissionParser} from '@/common/parsers/permissionParser';
import {Setting} from '@/common/parsers/settingsParser';
import {membershipRequestParser} from './membershipParser';
import { roleParser } from './roleParser';

export const authenticatedUserParser = object({
    email: string(),
    first: string(),
    full_name: string(),
    id: string(),
    last: string(),
    other_names: string().nullable(),
    permissions: array(permissionParser).nullable(),
    role: string(),
    type: string(),
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
        appointnment_date: string().nullable(),
        appointment_letter: string().nullable(),
        appointment_end_date: string().nullable(),
        serving_term: string().nullable(),
        current_period: string().nullable(),
        user_id: string(),
        created_at: string(),
        updated_at: string(),
    }),
    membership:membershipRequestParser,
});



export const userRequestParser = object({
    email: string(),
    first: string(),
    full_name: string(),
    id: string(),
    last: string(),
    other_names: string().nullable(),
    permissions: array(permissionParser).nullable(),
    // profile: profileParser,
    role: string(),
    type: string(),
});

export const userparser = object({//can be used from profile side import
    email: string(),
    first: string(),
    full_name: string(),
    id: string(),
    last: string(),
    other_names: string().nullable(),
    permissions: array(permissionParser),
    profile: object({//can be used from user side import
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
    role: string(),
    roles: array(roleParser),
    type: string(),
});
export const simpleuserparser = object({//can be used from profile side import
    email: string(),
    first: string(),
    full_name: string(),
    id: string(),
    last: string(),
    other_names: string().nullable(),
    profile: object({//can be used from user side import
        id: string(),
        avatar: string(),
    }),
});

export interface UserRequestPayload{
    id: string,
    email: string,
    role: string,
    first: string,
    last: string,
    id_number: string,
    phone: string,
}
export interface AcceptInviteRequestPayload{ //to db
    id:string | null,
    first:string,
    last:string,
    id_number:string,
    email:string|null,
    phone:string,
    password:string | null,
    token:string,
}

export interface AuthenticatedLoginUser  {
    code: number,
    data: {
        user: AuthenticatedUser;
        token: string;
        setting: Setting;
    };
    message: string
}
export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        users: User[];
    };
    message: string;
}
export interface nonPaginateResponse {
    code: number,
    data: User[],
    message: string
}
//profile upates
export interface SingleUserResponse {
    code: number,
    data: AuthenticatedUser,
    message: string
}
export interface singleresponse {
    code: number,
    data: User,
    message: string
}

export type User = output<typeof userparser>;

export type AuthenticatedUser = output<typeof authenticatedUserParser>;



