
import {array, object, output, string} from 'zod';


const valueParser = object({
    nameField: string(),
    namePlaceholder: string(),
    valueName: string(),
});
const mailParser = object({
    id:string(),
    name:string(),
    active:string(),
    values:array(valueParser),
});
export const settingsParser = object({ //from db
    id: string(),
    logo: string(),
    textlogo: string(),
    name: string(),
    about: string(),
    website: string(),
    iso: string(),
    isologo: string(),
    address: string(),
    county: string(),
    city: string(),
    state: string(),
    phone1: string(),
    phone2: string(),
    pspdkitlicencekey: string(),
    mailtype: mailParser,
});

export interface SettingsRequestPayload{ //to db
    id: string,
    logo:File | string,
    textlogo:File | string,
    name:string,
    about:string,
    website:string,
    iso:string,
    isologo:File | string,
    address:string,
    county:string,
    city:string,
    state:string,
    phone1:string,
    phone2:string,
    pspdkitlicencekey:string,
    mailtype:MailType
}




export interface singleSettingResponse { //from backend
    code: number,
    data: Settings,
    message: string,
}


export type MailType = output<typeof mailParser>;

export type Settings = output<typeof settingsParser>;



