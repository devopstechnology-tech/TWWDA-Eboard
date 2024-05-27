import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import {almanacRoute} from '@/common/api/almanac_routes';
import useClient from '@/common/api/client';
import {AlmanacRequestPayload,nonPaginateResponse} from '@/common/parsers/AlmanacParser';

// SUPERADMIN
export async function useGetAlmanacsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(almanacRoute() + '?' + cn).json();
}

//update via almanac 
export async function useCreateAlmanacRequest(payload: AlmanacRequestPayload){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/create',{
        json: payload,
    });
    return response.json();
}
export async function useUpdateAlmanacRequest(payload: AlmanacRequestPayload, id:string){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/update/' + id ,{
        json: payload,
    });
    return response.json();
}

export async function useApproveAlmanacRequest( id:string){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/approve/' + id);
    return response.json();
}
export async function useHeldAlmanacRequest( id:string){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/held/' + id);
    return response.json();
}
export async function useCancelledAlmanacRequest( id:string){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/cancelled/' + id);
    return response.json();
}
export async function usePostponedAlmanacRequest( id:string){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/postponed/' + id);
    return response.json();
}
export async function useDeleteAlmanacRequest(payload: AlmanacRequestPayload, id:string){
    const client = useClient();
    return await client.patch(almanacRoute() + '/delete/' + id ,{
        json: payload,
    });  
}
// download sample excel
export async function useExportAlmanacRequest(payload:object){
    const client = useClient();
    const response = await client.post(almanacRoute() + '/export/'+ payload.type,{
        json: payload,
    });
    return response.blob();
}
export async function useImportAlmanacRequest(payload: AlmanacRequestPayload){
    const client = useClient();
    const data = new FormData();
    console.log('upload', payload.fileupload);
    data.append('type', payload.type);
    data.append('purpose', payload.purpose);
    data.append('start', payload.start);
    data.append('end', payload.end);
    data.append('budget', payload.budget);
    data.append('status', payload.status);
    data.append('held', payload.held);
    data.append('fileupload', payload.fileupload);
    const response = await client.post(almanacRoute() + '/import',{
        body: data,
    });
    return response.json();
}


