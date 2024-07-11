import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {folderRoute} from '@/common/api/folder_routes';
import {singleFileResponse} from '@/common/parsers/FileParser';
import {FolderRequestPayload,nonPaginateResponse, singleMediaFileResponse} from '@/common/parsers/FolderParser';
import {Meta} from '@/common/types/types';

//all folders //superadmin
export async function useGetFoldersRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(folderRoute() + '?' + cn).json();
}

//board folders
export async function useGetBoardFoldersRequest(board_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(folderRoute()+ '/board/' + board_id + '?' + cn).json();
}

export async function useCreateBoardFolderRequest(
    payload: FolderRequestPayload,
    boardid: string,
){
    const client = useClient();
    const response = await client.post(folderRoute() + '/board/create/' + boardid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateBoardFolderRequest(
    payload: FolderRequestPayload,
    boardid: string,
    folderid: string,
){
    const client = useClient();
    const response = await client.patch(folderRoute() + '/board/update/' + boardid + '/'+ folderid,{
        json: payload,
    });
    return response.json();
}
//board file create and update anotaionadn so forth
export async function useCreateBoardUploadFolderRequest(
    payload: FolderRequestPayload,
    boardid: string,
){
    const client = useClient();
    const data = new FormData();
    data.append('board_id', payload.board_id);
    data.append('name', payload.name);
    data.append('parent_id', payload.parent_id);
    data.append('type', payload.type);
    data.append('fileupload', payload.fileupload);

    const response = await client.post(folderRoute() + '/board/file/create/' + boardid,{
        body: data,
    });
    return response.json();
}
export async function useUpdateBoardUploadFolderRequest(
    payload: FolderRequestPayload,
    boardid: string,
    folderid: string,
){
    const client = useClient();
    const data = new FormData();
    data.append('folder_id', payload.folder_id);
    data.append('board_id', payload.board_id);
    data.append('name', payload.name);
    data.append('parent_id', payload.parent_id);
    data.append('type', payload.type);
    data.append('fileupload', payload.fileupload);

    const response = await client.post(folderRoute() + '/board/file/update/' + boardid + '/'+ folderid,{
        body: data,
    });
    return response.json();
}



//committee folders
export async function useGetCommitteeFoldersRequest(committee_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(folderRoute()+ '/committee/' + committee_id + '?' + cn).json();
}

export async function useCreateCommitteeFolderRequest(
    payload: FolderRequestPayload,
    committeeid: string,
){
    const client = useClient();
    const response = await client.post(folderRoute() + '/committee/create/' + committeeid,{
        json: payload,
    });
    return response.json();
}

export async function useUpdateCommitteeFolderRequest(
    payload: FolderRequestPayload,
    committeeid: string,
    folderid: string,
){
    const client = useClient();
    const response = await client.patch(folderRoute() + '/committee/update/' + committeeid + '/'+ folderid,{
        json: payload,
    });
    return response.json();
}
//committee file create and update anotaionadn so forth
export async function useCreateCommitteeUploadFolderRequest(
    payload: FolderRequestPayload,
    committeeid: string,
){
    const client = useClient();
    const data = new FormData();
    data.append('committee_id', payload.committee_id);
    data.append('name', payload.name);
    data.append('parent_id', payload.parent_id);
    data.append('type', payload.type);
    data.append('fileupload', payload.fileupload);

    const response = await client.post(folderRoute() + '/committee/file/create/' + committeeid,{
        body: data,
    });
    return response.json();
}
export async function useUpdateCommitteeUploadFolderRequest(
    payload: FolderRequestPayload,
    committeeid: string,
    folderid: string,
){
    const client = useClient();
    const data = new FormData();
    data.append('folder_id', payload.folder_id);
    data.append('committee_id', payload.committee_id);
    data.append('name', payload.name);
    data.append('parent_id', payload.parent_id);
    data.append('type', payload.type);
    data.append('fileupload', payload.fileupload);

    const response = await client.post(folderRoute() + '/committee/file/update/' + committeeid + '/'+ folderid,{
        body: data,
    });
    return response.json();
}














//meetign folders
export async function useGetMeetingFoldersRequest(meeting_id:string, options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(folderRoute()+ '/meeting/' + meeting_id + '?' + cn).json();
}

export async function useCreateMeetingFolderRequest(
    payload: FolderRequestPayload,
    meetingid: string,
){
    const client = useClient();
    const response = await client.post(folderRoute() + '/meeting/create/' + meetingid,{
        json: payload,
    });
    return response.json();
}
export async function useCreateMeetingUploadFolderRequest(
    payload: FolderRequestPayload,
    meetingid: string,
){
    const client = useClient();
    const data = new FormData();
    data.append('meeting_id', payload.meeting_id);
    data.append('name', payload.name);
    data.append('parent_id', payload.parent_id);
    data.append('type', payload.type);
    data.append('fileupload', payload.fileupload);

    const response = await client.post(folderRoute() + '/meeting/file/create/' + meetingid ,{
        body: data,
    });
    return response.json();
}


//meetin gfile update anotaionadn so forth
export async function useUpdateMeetingUploadFolderRequest(
    payload: FolderRequestPayload,
    meetingid: string,
){
    const client = useClient();
    const data = new FormData();
    data.append('folder_id', payload.folder_id);
    data.append('meeting_id', payload.meeting_id);
    data.append('name', payload.name);
    data.append('parent_id', payload.parent_id);
    data.append('type', payload.type);
    data.append('fileupload', payload.fileupload);

    const response = await client.post(folderRoute() + '/meeting/file/update/' + meetingid,{
        body: data,
    });
    return response.json();
}

export async function useUpdateMeetingFolderRequest(
    payload: FolderRequestPayload,
    meetingid: string,
){
    const client = useClient();
    const response = await client.patch(folderRoute() + '/meeting/update/' + meetingid,{
        json: payload,
    });
    return response.json();
}


export async function useUpdateFolderRequest(payload: FolderRequestPayload, meetingid: string){
    const client = useClient();
    const response = await client.patch(folderRoute() + '/meeting/update/' + meetingid ,{
        json: payload,
    });
    return response.json();
}




