import useClient from '@/common/api/client';
import {settingsRoute} from '@/common/api/settings_routes';
import {LOCAL_SETTINGS} from '@/common/constants/localStorageKeys';
import {SettingsRequestPayload, singleSettingResponse} from '@/common/parsers/settingsParser';
import useSettingsStore from '@/common/stores/settings.store';

const settingsStore = useSettingsStore();

export async function useUpdateSettingRequest(payload:SettingsRequestPayload)
:Promise<singleSettingResponse> {
    const client = useClient();
    const updatedata = new FormData();
    updatedata.append('id',payload.id);
    updatedata.append('logo',payload.logo);
    updatedata.append('textlogo',payload.textlogo);
    updatedata.append('name',payload.name);
    updatedata.append('about',payload.about);
    updatedata.append('website',payload.website);
    updatedata.append('iso',payload.iso);
    updatedata.append('isologo',payload.isologo);
    updatedata.append('address',payload.address);
    updatedata.append('county',payload.county);
    updatedata.append('city',payload.city);
    updatedata.append('state',payload.state);
    updatedata.append('phone1',payload.phone1);
    updatedata.append('phone2',payload.phone2);
    updatedata.append('mailtype', JSON.stringify(payload.mailtype));
    updatedata.append('pspdkitlicencekey',payload.pspdkitlicencekey);
    const response: singleSettingResponse = await client.post(settingsRoute() + '/update/' + payload.id ,{
        body: updatedata,
    }).json();
    // Update local storage
    localStorage.setItem(LOCAL_SETTINGS, JSON.stringify(response.data));

    // Load and save settings in the Pinia store
    await settingsStore.loadAndSaveSettings();
    return response;
}


