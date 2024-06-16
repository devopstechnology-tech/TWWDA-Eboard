import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {positionsRoute} from '@/common/api/position_routes';
import {nonPaginateResponse,PositionRequestPayload} from '@/common/parsers/positionParser';




export async function useGetPositionsRequest(options?: object):Promise<nonPaginateResponse>{
    const client = useClient();

    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(positionsRoute()+ '/' + '?' + cn).json();
}

export async function useCreatePositionRequest(payload: PositionRequestPayload){
    const client = useClient();
    const response = await client.post(positionsRoute() + '/create/',{
        json: payload,
    });
    return response.json();
}

export async function useUpdatePositionRequest(payload: PositionRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(positionsRoute() + '/update/' + id, {
        json: payload,
    }).json();
}

export async function useUpdateSubPositionRequest(payload: PositionRequestPayload, id: string | null) {
    const client = useClient();

    await client.post(positionsRoute() + '/update/' + id, {
        json: payload,
    }).json();
}

export async function useGetActivatePositionRequest(id: string | null) {
    const client = useClient();

    await client.patch(positionsRoute() + '/activate/' + id).json();
}
export async function useGetDeactivatePositionRequest(id: string | null) {
    const client = useClient();

    await client.patch(positionsRoute() + '/deactivate/' + id).json();
}

export async function useDeletePositionsRequest(id: string | null) {
    const client = useClient();

    await client.delete(positionsRoute() + '/delete/' + id).json();
}





