
import {array, object, output, string} from 'zod';
import {TaskAssignee, taskassigneeParser} from '@/common/parsers/TaskAssigneeParser';

export const taskParser = object({
    id:string(), //from db
    meeting_id:string().nullable(),
    board_id:string().nullable(),
    committee_id:string().nullable(),    
    title:string(),
    duedate:string(),
    description:string(),
    status:string(),
    assigneetype:string(),
    assigneestatus:string(),
    taskstatuses:array(object({
        id:string(),
        task_id:string(),
        assignee_task_id:string(),
        date:string(),
        status:string(),
    })),
    taskassignees:array(taskassigneeParser),
});

export interface TaskRequestPayload{ //to db
    meeting_id:string| null,
    board_id:string| null,
    committee_id:string| null,
    title:string,
    duedate:string,
    description:string,
    status:string,
    assigneetype:string,
    assigneestatus:string,
    taskassignees:TaskAssignee[],
}
export interface TaskWorkRequestPayload{ //to db
    taskstatus_id:string|null,
    task_id:string,
    task_assignee_id:string,
    selectedOption:string,
}





export interface TaskMembersRequestPayload {
    members: string[],
}

export interface SelectedResult {
    id: number,
    name: string,
}
export interface TaskMemberEditParams {
    id: string;
    members: {
      [x: string]: any;

user: any; id: string; full_name: string;
}[];
}

export interface NonPaginateLatestResponse {
    code: number;
    data: {
        count: number;
        tasks: Task[];
    };
    message: string;
}

export interface nonPaginateResponse {
    code: number,
    data: Task[],
    message: string
}

export type Task = output<typeof taskParser>;



