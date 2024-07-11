
import {array, nullable, number, object, output, string} from 'zod';
import {folderChildRequestParser} from '@/common/parsers/FolderChildParser';
import {mediaRequestParser} from './mediaPaser';

export const folderRequestParser = object({
    id: string(),
    name: string(),
    type: string(),
    fileupload: string().nullable(),
    parent_id: string(),
    meeting_id: string(),
    folder_id: string().nullable(),
    children: array(folderChildRequestParser).nullable(),
    icon: string(),
    media:array(mediaRequestParser).nullable(),
    created_at: string(),
});

export interface FolderRequestPayload{ //to db
    id: string| null,
    name: string,
    parent_id: string,
    meeting_id: string,
    board_id: string|null,
    committee_id: string|null,
    folder_id: string| null,
    media: [],
    type: string,
    fileupload: File | string | null,
    children: string[],
    icon: string| null,
    created_at: string| null,
}

export interface SelectedResult {
    id: number,
    name: string,
}

export interface nonPaginateResponse {
    code: number,
    data: Folder[],
    message: string
}

export type Folder = output<typeof folderRequestParser>;





