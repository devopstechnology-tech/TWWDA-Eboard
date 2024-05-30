import useClient from '@/common/api/client';
import {changePasswordRoute, forgotPasswordRoute, staffLoginRoute} from '@/common/api/staff_routes';
import {LOCAL_MAILTYPES,LOCAL_SETTINGS, LOCAL_TOKEN} from '@/common/constants/localStorageKeys';
import {AuthenticatedLoginUser, AuthenticatedUser} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';
import useMailTypesStore from '@/common/stores/mailtypes.store';
import useSettingsStore from '@/common/stores/settings.store';
import {AuthenticateRequestPayload, ChangePasswordPayload, ForgotPasswordPayload} from '@/common/types/types';
import { LOCAL_USER } from '../../../constants/localStorageKeys';

const authStore     = useAuthStore();
const settingsStore = useSettingsStore();
const mailtypesStore = useMailTypesStore();

export async function useStaffLoginRequest(payload: AuthenticateRequestPayload): Promise<AuthenticatedUser> {
    const client = useClient();

    const responsePayload = await client.post(staffLoginRoute(), {
        json: payload,
    }).json() as AuthenticatedLoginUser;
    // Extract mailtypes and separate them from settings
    // const mailTypes = responsePayload.data.setting.mailtypes;
    // delete responsePayload.data.setting.mailtypes;

    // // Store the token and settings in local storage
    // localStorage.setItem(LOCAL_TOKEN, responsePayload.data.token);
    // localStorage.setItem(LOCAL_SETTINGS, JSON.stringify(responsePayload.data.setting));
    // localStorage.setItem(LOCAL_MAILTYPES, JSON.stringify(mailTypes));

    // // Update stores
    // authStore.setUser(responsePayload.data.user);
    // settingsStore.setSettings(responsePayload.data.setting);
    // mailtypesStore.setMailTypes(mailTypes);

    return propagate(responsePayload);
}
export async function useForgotPasswordRequest(payload: ForgotPasswordPayload){
    const client = useClient();

    return await client.post(forgotPasswordRoute(), {
        json: payload,
    }).json();
}
export async function useChangePasswordRequest(payload: ChangePasswordPayload): Promise<AuthenticatedUser> {
    const client = useClient();

    const responsePayload =  await client.post(changePasswordRoute(), {
        json: payload,
    }).json() as AuthenticatedLoginUser;

    // Extract mailtypes and separate them from settings
    // const mailTypes = responsePayload.data.setting.mailtypes;
    // delete responsePayload.data.setting.mailtypes;

    // // Store the token and settings in local storage
    // localStorage.setItem(LOCAL_TOKEN, responsePayload.data.token);
    // localStorage.setItem(LOCAL_SETTINGS, JSON.stringify(responsePayload.data.setting));
    // localStorage.setItem(LOCAL_MAILTYPES, JSON.stringify(mailTypes));

    // // Update stores
    // authStore.setUser(responsePayload.data.user);
    // settingsStore.setSettings(responsePayload.data.setting);
    // mailtypesStore.setMailTypes(mailTypes);

    return propagate(responsePayload);
}

export async function propagate(responsePayload: AuthenticatedLoginUser){
    const mailTypes = responsePayload.data.setting.mailtypes;
    delete responsePayload.data.setting.mailtypes;

    // Store the token and settings in local storage
    localStorage.setItem(LOCAL_USER, JSON.stringify(responsePayload.data.user));
    localStorage.setItem(LOCAL_TOKEN, responsePayload.data.token);
    localStorage.setItem(LOCAL_SETTINGS, JSON.stringify(responsePayload.data.setting));
    localStorage.setItem(LOCAL_MAILTYPES, JSON.stringify(mailTypes));

    // Update stores
    authStore.setUser(responsePayload.data.user);
    settingsStore.setSettings(responsePayload.data.setting);
    mailtypesStore.setMailTypes(mailTypes);

    return responsePayload.data.user;
}