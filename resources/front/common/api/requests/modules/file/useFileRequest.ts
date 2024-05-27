import {notify} from '@kyvg/vue3-notification';
import PSPDFKit from 'pspdfkit';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {folderRoute} from '@/common/api/folder_routes';
import {FileRequestPayload, singleFileResponse} from '@/common/parsers/FileParser';


//board
// /file
export async function useGetBoardFileRequest(
    board_id:string,
    file_id:string,
    folder_id:string,
):Promise<singleFileResponse>{
    const client = useClient();
    const data: singleFileResponse =
    await client.get(folderRoute()+ '/board/' + board_id + '/folder/'+ folder_id +'/file/'+ file_id).json();
    return data;
}

// /file
export async function useGetFileRequest(
    folderId:string,
    mediaId:string,
):Promise<singleFileResponse>{
    const client = useClient();
    const data: singleFileResponse = //folders/{folder}/file/{file}
    await client.get(folderRoute()+'/'+ folderId +'/file/'+ mediaId).json();
    return data;
}


// default update file from viewing with PSPDFKit, iregardless where viewing from : documents in meeting or boarding
export async function useUpdateFileRequest(
    payload: FileRequestPayload,
    folderId:string,
    mediaId:string,
):Promise<singleFileResponse>{
    const client = useClient();
    const formdata = new FormData();
    formdata.append('folder_id', payload.folder_id);
    formdata.append('name', payload.name);
    formdata.append('type', payload.type);
    formdata.append('fileupload', payload.fileupload);

    const data: singleFileResponse =
    await client.post(folderRoute() +'/update/'+ folderId +'/file/'+ mediaId, {
        body: formdata,
    }).json();

    return data;
}



