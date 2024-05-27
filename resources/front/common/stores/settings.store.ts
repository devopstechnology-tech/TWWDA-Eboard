import {defineStore} from 'pinia';
import {ref} from 'vue';
import useClient from '@/common/api/client';
import {settingsRoute} from '@/common/api/settings_routes';
import {LOCAL_SETTINGS} from '@/common/constants/localStorageKeys';
import {Settings, settingsParser, singleSettingResponse} from '@/common/parsers/settingsParser';

export const useSettingsStore = defineStore('settings', () => {
    const settings = ref<Settings | null>(null);

    // Initialize settings from local storage
    const initializeSettings = () => {
        const storedSettings = localStorage.getItem(LOCAL_SETTINGS);
        if (storedSettings) {
            settings.value = JSON.parse(storedSettings) as Settings;
        }
    };

    const setSettings = (setting: Settings) => {
        settings.value = setting;
        localStorage.setItem(LOCAL_SETTINGS, JSON.stringify(setting));
    };

    const fetchAndSetSettings = async (): Promise<singleSettingResponse> => {
        const client = useClient();
        try {
            const response: singleSettingResponse = await client.get(settingsRoute()).json();
            const result = settingsParser.safeParse(response.data);

            if (result.success) {
                const fetchedSettings = result.data;
                setSettings(fetchedSettings);
                return response;
            } else {
                console.error('Validation error:', result.error);
                throw new Error('Failed to validate settings from the backend.');
            }
        } catch (error) {
            console.error('Error fetching settings:', error);
            throw new Error('Error during fetching and setting settings.');
        }
    };

    const loadAndSaveSettings = async () => {
        const storedSettings = localStorage.getItem(LOCAL_SETTINGS);
        if (storedSettings) {
            settings.value = JSON.parse(storedSettings) as Settings;
        } else {
            try {
                const response = await fetchAndSetSettings();
                settings.value = response.data;
            } catch (error) {
                console.error('Failed to fetch settings:', error);
                settings.value = null;
            }
        }
    };

    const resetSettings = () => {
        settings.value = null;
        localStorage.removeItem(LOCAL_SETTINGS);
    };

    const getSettings = () => {
        return settings.value;
    };

    // Initialize settings on store creation
    initializeSettings();

    return {
        setSettings,
        getSettings,
        fetchAndSetSettings,
        resetSettings,
        loadAndSaveSettings,
    };
});

export default useSettingsStore;
