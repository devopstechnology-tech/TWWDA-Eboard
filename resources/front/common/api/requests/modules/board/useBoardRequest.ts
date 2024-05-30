import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import {boardMemberRoute,boardRoute} from '@/common/api/board_routes';
import useClient from '@/common/api/client';
import {committeeMemberRoute} from '@/common/api/committee_routes';
import {BoardMembersRequestPayload, BoardRequest, BoardRequestPayload} from '@/common/parsers/boadParser';
import {Meta} from '@/common/types/types';

interface response {
    code: number,
    data: {
        data: BoardRequest[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: BoardRequest,
    message: string
}

export async function useCreateBoardRequest(
    payload: BoardRequestPayload) {
    const client = useClient();
    const data = new FormData();
    data.append('name', payload.name);
    data.append('description', payload.description);
    data.append('icon', payload.icon);
    data.append('cover', payload.cover);

    console.log('we are here payload', data, payload);
    const response = await client.post(boardRoute(),{
        body: data,
    });
    return response.json();
}

export async function useGetBoardsRequest(options?: object): Promise<response> {
    const client = useClient();
    return await client.get(boardRoute()).json();
}

export async function useUpdateBoardRequest(
    payload: BoardRequestPayload, id: string){
    console.log('payload',payload);
    const client = useClient();
    const updatedata = new FormData();
    updatedata.append('name', payload.name);
    updatedata.append('description', payload.description);
    updatedata.append('icon', payload.icon);
    updatedata.append('cover', payload.cover);

    console.log('updatedata',updatedata);
    const response = await client.post(boardRoute() + '/update/' + id,{
        body: updatedata,
    });
    return response.json();
}

//

export async function useGetSingleBoardRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(boardRoute() + '/' + id).json();
    return data;
}

export async function useUpdateBoardMembersRequest(payload: BoardMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(boardMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useDeleteBoardRequest(id: string){
    // console.log('id', id);
    const client = useClient();
    return await client.delete(boardRoute() + '/' + id).json();
}