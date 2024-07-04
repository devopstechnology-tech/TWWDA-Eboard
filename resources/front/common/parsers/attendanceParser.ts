
import {array, object, output, string} from 'zod';
import {mediaRequestParser} from './mediaPaser';
import { objectPick } from '@vueuse/core';
import { permissionParser } from './permissionParser';
import { positionParser } from './positionParser';

export const attendanceParser = object({
    id:string(),
    location:string(),
    invite_status:string(),
    rsvp_status:string(),
    attendance_status:string(),
    meeting_id:string(),
    membership_id:string(),
    membership:object({
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
    }),
    schedule:object({
        id:string(), //from db
        date:string(),
        start_time:string(),
        end_time:string(),
        status: string(),
        heldstatus: string(),
        meeting_id:string(),
        meeting:object({
            id: string(),
            title: string(),
            conference: string(),
            location: string(),
            description: string(),
            link: string().nullable(),
            status: string(),
            type: string(),
            committee_id: string(),
        }),
    }),
    meeting:string(),
    media:array(mediaRequestParser).nullable(),
});

export interface AttendanceRequestPayload{ //to db
    id:string,
    location:string|null,
    invite_status:string|null,
    rsvp_status:string|null,
    attendance_status:string|null,
    meeting_id:string|null,
    membership_id:string|null,
    membership:string|null,
    meeting:string|null,
    signatureupload: File | string | null,
}

export interface SignatureRequestPayload{ //to db
    id: string,
    name: string,
    // ip: string,
    // location: string,
    signatureupload: File,
}


export const signatureDataParser = object({//from db
    fileName:string(),
    fileSize:string(),
    fileType:string(),
    file:string(),
    attendance:attendanceParser,
    mediaId:string(),
});

export interface singleSignaturefileResponse { //from backend
    code: number,
    data: SignatureFileData,
    message: string,
}

export type SignatureFileData = output<typeof signatureDataParser>;

export interface nonPaginateResponse {
    code: number,
    data: Attendance[],
    message: string
}

export type Attendance = output<typeof attendanceParser>;




