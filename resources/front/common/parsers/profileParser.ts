
import {array, nullable, number, object, output, string} from 'zod';
import {userparser} from '@/common/parsers/userParser';

export const profileRequestParser = object({
    id: string(),
    avatar: string().nullable(),
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
    user:userparser,
    created_at: string(),
    updated_at: string(),
});
export const profileParser = object({//can be used from user side import
    id: string(),
    avatar: string().nullable(),
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
});

export interface ProfileSelfRequestPayload{ //to db
    id: string,
    avatar: string,
    ethnicity: string,
    phone: string,
    idpassportnumber: string,
    gender_id: string,
    address: string,
    home_county_id: string,
    residence_county_id: string,
    city: string,
    state: string,
    nationality: string,
    about: string,
    kra_pin: string,
    member_cv: string,
    establishment: string,
    user_id: string,
}
export interface AdminProfileRequestPayload{ //updated to db
    id: string,
    avatar: string,
    ethnicity: string,
    phone: string,
    idpassportnumber: string,
    gender_id: string,
    address: string,
    home_county_id: string,
    residence_county_id: string,
    city: string,
    state: string,
    nationality: string,
    about: string,
    kra_pin: string,
    member_cv: string,
    establishment: string,
    title: string,
    appointing_authority: string,
    appointnment_date: string,
    appointment_letter: string,
    appointment_end_date: string,
    serving_term: string,
    current_period: string,
    user_id: string,
}


export interface singleProfileResponse { //from backend
    code: number,
    data: Profile,
    message: string,
}

export type Profile = output<typeof profileRequestParser>;







