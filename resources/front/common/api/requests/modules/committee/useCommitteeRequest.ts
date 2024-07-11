import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {committeeMemberRoute,committeeRoute} from '@/common/api/committee_routes';
import {
    CommitteeMembersRequestPayload, 
    CommitteeRequestPayload, 
    nonPaginateResponse,
    singleCommitteeResponse, 
} from '@/common/parsers/committeeParser';

export async function useGetLatestCommitteesRequest(options?: object): Promise<nonPaginateResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(committeeRoute() + '/latest'+ '?' + cn).json();
}
export async function useGetCommitteesRequest(options?: object): Promise<nonPaginateResponse> {
    const client = useClient();
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(committeeRoute() + '?' + cn).json();
}
export async function useCreateCommitteeRequest(
    payload: CommitteeRequestPayload,
    boardId: string,
) {
    const client = useClient();
    const data = new FormData();
    data.append('name', payload.name);
    data.append('description', payload.description);
    data.append('icon', payload.icon);
    data.append('cover', payload.cover);
    const response = await client.post(committeeRoute()+'/create/'+ boardId, {
        body: data,
    });
    return response.json();
}


export async function useUpdateCommitteeRequest(
    payload: CommitteeRequestPayload, 
    committeeid: string,
){
    const client = useClient();
    const updatedata = new FormData();
    updatedata.append('name', payload.name);
    updatedata.append('description', payload.description);
    updatedata.append('icon', payload.icon);
    updatedata.append('cover', payload.cover);

    const response = await client.post(committeeRoute() + '/update/' + committeeid,{
        body: updatedata,
    });
    return response.json();
}

//

export async function useGetSingleCommitteeRequest(
    id: string): Promise<singleCommitteeResponse> {
    const client = useClient();
    const data: singleCommitteeResponse = await client.get(committeeRoute() + '/' + id).json();
    return data;
}

export async function useUpdateCommitteeMembersRequest(
    payload: CommitteeMembersRequestPayload, 
    boardid: string,
    committeeid: string,
) {
    const client = useClient();

    await client.post(committeeMemberRoute() + '/' + boardid + '/' + committeeid, {
        json: payload,
    }).json();
}

export async function useDeleteCommitteeRequest(id: string){
    // console.log('id', id);
    const client = useClient();
    return await client.delete(committeeRoute() + '/' + id).json();
}

