
import {icon} from '@fortawesome/fontawesome-svg-core';
import {array, nullable, number, object, output, string} from 'zod';
import {agendaassigneeParser} from '@/common/parsers/agendaassigneeParser';
import {SubAgenda, subagendaParser} from '@/common/parsers/subagendaParser';

export const agendaRequestParser = object({
    id:string(), //from db
    schedule_id:string(), //from db
    title: string(),
    duration: number(),
    description: string(),
    agenda_id: string().nullable(),
    children:array(subagendaParser).nullable(),
    assignees:array(agendaassigneeParser).nullable(),
});


export interface AgendaRequestPayload{ //to db
    title: string,
    schedule_id: string,
    duration: number | null,
    description: string | null,
    agenda_id: string | null,
    assignees: string[],
    children: SubAgenda[]| null,
}
export interface AgendaMembersRequestPayload {
    members: string[],
}


export interface SelectedResult {
    id: number,
    name: string,
}
export interface AgendaMemberEditParams {
    id: string;
    members: {
      [x: string]: any;

user: any; id: string; full_name: string;
}[];
}



export interface nonPaginateResponse {
    code: number,
    data: Agenda[],
    message: string
}

export type Agenda = output<typeof agendaRequestParser>;


// for creating deafault during creation of minutes
export interface DefaultAgenda {
    id: string,
    title: string,
    children?: DefaultAgenda[],
};


