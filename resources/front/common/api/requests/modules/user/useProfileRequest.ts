import useClient from '@/common/api/client';
import {profileRoute} from '@/common/api/profile_routes';
import {ProfileRequestPayload, singleProfileResponse} from '@/common/parsers/profileParser';



export async function useGetProfileRequest(profileId: string)
:Promise<singleProfileResponse> {
    const client = useClient();
    const data: singleProfileResponse = await client.get(profileRoute() + '/' + profileId).json();
    return data;
}
export async function useUpdateProfileRequest(payload, profileId: string)
:Promise<singleProfileResponse> {
    const client = useClient();
    const updatedata = new FormData();
    updatedata.append('name', payload.name);
    updatedata.append('id', payload.id);
    updatedata.append('first', payload.first);
    updatedata.append('last', payload.last);
    updatedata.append('other_names', payload.other_names);
    updatedata.append('email', payload.email);
    updatedata.append('password', payload.password);
    updatedata.append('avatar', payload.avatar);
    updatedata.append('ethnicity', payload.ethnicity);
    updatedata.append('phone', payload.phone);
    updatedata.append('idpassportnumber', payload.idpassportnumber);
    updatedata.append('gender_id', payload.gender_id);
    updatedata.append('about', payload.about);
    updatedata.append('address', payload.address);
    updatedata.append('home_county_id', payload.home_county_id);
    updatedata.append('residence_county_id', payload.residence_county_id);
    updatedata.append('city', payload.city);
    updatedata.append('state', payload.state);
    updatedata.append('nationality', payload.nationality);
    updatedata.append('kra_pin', payload.kra_pin);
    updatedata.append('member_cv', payload.member_cv);
    updatedata.append('establishment', payload.establishment);
    updatedata.append('title', payload.title);
    updatedata.append('appointing_authority', payload.appointing_authority);
    updatedata.append('appointment_date', payload.appointment_date);
    updatedata.append('appointment_letter', payload.appointment_letter);
    updatedata.append('appointment_end_date', payload.appointment_end_date);
    updatedata.append('serving_term', payload.serving_term);
    updatedata.append('current_period', payload.current_period);
    updatedata.append('user_id', payload.user_id);

    const data: singleProfileResponse = await client.post(profileRoute() + '/update/' + profileId ,{
        body: updatedata,
    }).json();
    return data;
}
