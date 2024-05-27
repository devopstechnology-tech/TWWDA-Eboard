
import {array, nullable, number, object, output, string} from 'zod';


export const fileDataParser = object({//from db
    fileName:string(),
    fileSize:string(),
    fileType:string(),
    file:string(),
    folderId:string(),
    mediaId:string(),
    // media:object({
    //     collection_name:string(),
    //     conversions_disk:string(),
    //     created_at:string(),
    //     deleted_at:string().nullable(),
    //     file_name:string(),
    //     id:string(),
    //     mime_type:string(),
    //     model_id:string(),
    //     model_type:string(),
    //     name:string(),
    //     order_column:string(),
    //     original_url:string(),
    //     preview_url:string(),
    //     size:string(),
    //     updated_at:string(),
    //     uuid:string(),
    // }),
});


export interface FileRequestPayload{ //to db
    name: string,
    folder_id: string,
    type: string,
    fileupload: File,
}


export interface singleFileResponse { //from backend
    code: number,
    data: FileData,
    message: string,
}
export type FileData = output<typeof fileDataParser>;


