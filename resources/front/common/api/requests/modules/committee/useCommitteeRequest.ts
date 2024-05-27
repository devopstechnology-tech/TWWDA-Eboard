import {notify} from '@kyvg/vue3-notification';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {committeeMemberRoute,committeeRoute} from '@/common/api/committee_routes';
import {Committee} from '@/common/parsers/committeeParser';
import {Meta} from '@/common/types/types';

interface CommitteeRequestPayload {
    name: string,
    description: string,
    icon: string,
    cover: File,
}
interface CommitteeMembersRequestPayload {
    members: string[],
}


interface CommitteeMember {
    id: string;
    full_name: string;
  }

  interface CommitteeMembersContainer {
    members: CommitteeMember[];
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

// export async function useCreateCommitteeRequest(payload: CommitteeRequestPayload | FormData) {
//     // loading.setLoading(true);
//     const client = useClient();

//     await client.post(committeeRoute(), {
//         json: payload,
//     }).json();
//     // loading.setLoading(false);
// }

// export async function useCreateCommitteeRequest(payload: CommitteeRequestPayload | FormData) {
//     const client = useClient();
//     const headers = {};
//     let body;

//     if (payload instanceof FormData) {
//         // For FormData, let the browser set the Content-Type header
//         body = payload;
//     } else {
//         // For JSON, set Content-Type to application/json
//         headers['Content-Type'] = 'application/json';
//         body = JSON.stringify(payload);
//     }

//     if (payload instanceof FormData) {
//         // Handle as FormData
//         await client.post(committeeRoute(), {
//             body: payload, // For FormData, use body
//         }).json();
//     } else {
//         // Handle as JSON
//         await client.post(committeeRoute(), {
//             json: payload, // For JSON payload, use json
//         }).json();
//     }
// }


// export async function useUpdateCommitteeRequest(payload: CommitteeRequestPayload | FormData, id: number) {
//     // loading.setLoading(true);
//     const client = useClient();
//     if (payload instanceof FormData) {
//         // When payload is FormData, use it directly in the body
//         await client.patch(committeeRoute() + '/' + id, {
//             body: payload,
//         }).json();
//     } else {
//         // When payload is JSON, send it as application/json
//         await client.patch(committeeRoute() + '/' + id, {
//             json: payload,
//         }).json();
//     }
// }
// Import or define `useClient` and `committeeRoute` as needed
// Ensure these are correctly set up to interface with your API

export async function useCreateCommitteeRequest(payload: CommitteeRequestPayload | FormData) {
    const client = useClient();

    // Decide headers and body based on the payload type
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Use a single API call with conditional settings
    const response = await client.post(committeeRoute(), {
        headers,
        body,
    });

    return response.json();
}

export async function useUpdateCommitteeRequest(payload: CommitteeRequestPayload | FormData, id: string) {
    const client = useClient();

    // Similar handling as in the create function
    const isFormData = payload instanceof FormData;
    const headers = isFormData ? {} : {'Content-Type': 'application/json'};
    const body = isFormData ? payload : JSON.stringify(payload);

    // Update request with PATCH method
    const response = await client.patch(committeeRoute() + '/' + id, {
        headers,
        body,
    });

    return response.json();
}
export async function useUpdateCommitteeMembersRequest(payload: CommitteeMembersRequestPayload, id: string) {
    const client = useClient();

    await client.post(committeeMemberRoute() + '/' + id, {
        json: payload,
    }).json();
}

export async function useGetCommitteesRequest(options?: object): Promise<response> {
    const client = useClient();

    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    // const cn = Qs.stringify(options, {arrayFormat: 'brackets'});
    return await client.get(committeeRoute()).json();
}

export async function useGetSingleCommitteeRequest(id: string): Promise<singleresponse> {
    // console.log('id', id);
    const client = useClient();
    const data: singleresponse = await client.get(committeeRoute() + '/' + id).json();
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


