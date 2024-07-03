import {notify} from '@kyvg/vue3-notification';
import PSPDFKit from 'pspdfkit';
import Qs from 'qs';
import useClient from '@/common/api/client';
import {AttendancesRoute, attendanceRoute} from '@/common/api/attendance_routes';
import { SignatureRequestPayload, singleSignaturefileResponse } from '@/common/parsers/attendanceParser';


// /signaturefile
export async function useGetSignatureFileRequest(
    attendanceId:string,
    mediaId:string,
):Promise<singleSignaturefileResponse>{
    const client = useClient();
    const data: singleSignaturefileResponse = //attendances/{attendance}/signaturefile/{signaturefile}
    await client.get(AttendancesRoute()+'/signature/'+ attendanceId +'/'+ mediaId).json();
    return data;
}

// default update signaturefile from viewing with PSPDFKit, iregardless where viewing from : documents in meeting or boarding
export async function useUpdateSignatureFileRequest(
    payload: SignatureRequestPayload,
    attendanceId:string,
    mediaId:string,
):Promise<singleSignaturefileResponse>{
    const client = useClient();
    const formdata = new FormData();
    formdata.append('id', payload.id);
    formdata.append('name', payload.name);
    formdata.append('signatureupload', payload.signatureupload);

    const data: singleSignaturefileResponse =
    await client.post(AttendancesRoute() +'/update/signature/'+ attendanceId + '/'+ mediaId, {
        body: formdata,
    }).json();

    return data;
}




