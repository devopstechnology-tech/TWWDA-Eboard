
import {array, object, output, string} from 'zod';

export const valueParser = object({
    nameField: string(),
    namePlaceholder: string(),
    valueName: string(),
});
export const mailtypeParser = object({
    id:string(),
    name:string(),
    active:string(),
    values:array(valueParser),
});


export interface MailtypeRequestPayload{ //to db
    id:string,
    name:string,
    active:string,
    values:ValueType[],
}

export interface singleMailTypeResponse { //from backend
    code: number,
    data: MailType,
    message: string,
}
export interface MailTypesResponse { //from backend
    code: number,
    data: MailType[],
    message: string,
}


export type ValueType = output<typeof valueParser>;
export type MailType = output<typeof mailtypeParser>;



