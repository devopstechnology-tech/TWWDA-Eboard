import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {taskRoute} from '@/common/api/task_routes';
import {nonPaginateResponse,TaskRequestPayload} from '@/common/parsers/TaskParser';
import {Meta} from '@/common/types/types';


//all tasks
export async function useGetTasksRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(taskRoute() + '?' + cn).json();
}
//meetign tasks
export async function useGetMeetingTasksRequest(meeting_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(taskRoute()+ '/meeting/' + meeting_id + '?' + cn).json();
}

export async function useCreateMeetingTaskRequest(payload: TaskRequestPayload, meetingid: string,  boardid: string){
    const client = useClient();
    const response = await client.post(taskRoute() + '/meeting/create/' + meetingid + '/board/' + boardid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateMeetingTaskRequest(
    payload: TaskRequestPayload, 
    meetingid: string,  
    boardid: string, 
    taskid:string,
){
    const client = useClient();
    const response = await 
    client.patch(taskRoute() + '/meeting/update/' + meetingid + '/board/' + boardid +'/' + taskid,{
        json: payload,
    });
    return response.json();
}
export async function useUpdateTaskRequest(payload: TaskRequestPayload, meetingid: string){
    const client = useClient();
    const response = await client.patch(taskRoute() + '/meeting/update/' + meetingid ,{
        json: payload,
    });
    return response.json();
}



