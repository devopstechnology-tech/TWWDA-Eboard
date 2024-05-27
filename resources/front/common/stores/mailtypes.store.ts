// mailtypes.store.ts
import {defineStore} from 'pinia';
import {ref} from 'vue';
import useClient from '@/common/api/client'; // Assumed import for HTTP client
import {LOCAL_MAILTYPES} from '@/common/constants/localStorageKeys';
import {MailType, mailtypeParser, MailTypesResponse} from '@/common/parsers/mailtypeParser'; // Make sure to import MailTypesResponse
import {settingsRoute} from '../api/settings_routes';

export const useMailTypesStore = defineStore('mailtypes', () => {
    const mailTypes = ref<MailType[] | null>(null);

    function setMailTypes(mailtype: MailType[]) {
        mailTypes.value = mailtype;
    }
    async function fetchAndSetMailTypes(): Promise<MailTypesResponse> {
        const client = useClient();
        try {
            // Assume the API returns MailTypesResponse directly
            const response: MailTypesResponse = await client.get(settingsRoute()+'/mailtypes').json();
            // Validate the response data before using it
            const result = mailtypeParser.array().safeParse(response.data);

            if (result.success) {
                return response;
            } else {
                console.error('Validation error:', result.error);
                throw new Error('Failed to validate mail types from the backend.');
            }
        } catch (error) {
            console.error('Error fetching mail types:', error);
            throw new Error('Error during fetching and setting mail types.');
        }
    }


    const loadAndSaveMailTypes = async () => {
        const storedMailTypes = localStorage.getItem(LOCAL_MAILTYPES);
        if (storedMailTypes) {
            mailTypes.value = JSON.parse(storedMailTypes);
        } else {
            try {
                const response = await fetchAndSetMailTypes();
                const fetchedMailTypes = response.data;
                localStorage.setItem(
                    LOCAL_MAILTYPES, JSON.stringify(fetchedMailTypes),
                );   // Return the response as is or manipulate as needed 
                mailTypes.value = fetchedMailTypes;
                return mailTypes.value;
            } catch (error) {
                console.error('Failed to fetch mail types:', error);
                mailTypes.value = null;  // Ensure state is consistent in case of an error
            }
        }
    };

    const resetMailTypes = () => {
        mailTypes.value = null;
        localStorage.removeItem(LOCAL_MAILTYPES);
    };
    const getMailTypes = () => {
        return mailTypes.value;
    };

    return {
        setMailTypes,
        getMailTypes,
        fetchAndSetMailTypes,
        resetMailTypes,
        loadAndSaveMailTypes,
    };
});

export default useMailTypesStore;
