import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {committeeRoute} from '@/common/api/committee_routes';
import {Committee} from '@/common/parsers/committeeParser';
import {Meta} from '@/common/types/types';

interface CommitteeRequestPayload {
    first: string;
    last: string;
    id_number: string;
    phone: string;
    email: string;
    // department_id: number;
    // pos_account_id: number;
    // image: File;
    // description: null | string;
}

interface response {
    code: number,
    data: {
        data: Committee[],
        meta: Meta
    },
    message: string
}

interface singleresponse {
    code: number,
    data: Committee,
    message: string
}

export async function useCreateCommitteeRequest(payload: CommitteeRequestPayload) {
    // loading.setLoading(true);
    const client = useClient();

    await client.post(committeeRoute(), {
        json: payload,
    }).json();
    // loading.setLoading(false);
}

export async function useUpdateCommitteeRequest(payload: CommitteeRequestPayload, id: number) {
    // loading.setLoading(true);
    const client = useClient();

    await client.patch(committeeRoute() + '/' + id, {
        json: payload,
    }).json();
    // loading.setLoading(false);
}

export async function useGetCommitteesRequest(options?: object): Promise<response> {
    const client = useClient();

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(committeeRoute() + '?' + cn).json();
}

export async function useGetSingleCommitteesRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.get(committeeRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}

export async function useDeleteCommitteeRequest(id: string): Promise<singleresponse> {
    // loading.setLoading(true);
    const client = useClient();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    const data: singleresponse = await client.delete(committeeRoute() + '/' + id).json();
    // loading.setLoading(false);
    return data;
}


