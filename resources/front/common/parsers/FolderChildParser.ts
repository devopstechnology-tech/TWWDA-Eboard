
import {array, nullable, number, object, output, string} from 'zod';
// import {folderassigneeParser} from '@/common/parsers/FolderAssigneeParser';

export const folderChildRequestParser = object({
    id: string(),
    name: string(),
    type: string(),
    children: array(folderChildRequestParser).nullable(),
    icon: string(),
    created_at: string(),
});



export type Folder = output<typeof folderChildRequestParser>;
