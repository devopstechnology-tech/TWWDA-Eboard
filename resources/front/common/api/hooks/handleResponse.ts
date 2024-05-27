import {notify} from '@kyvg/vue3-notification';
import {AfterResponseHook} from 'ky';
import {HTTP_MULTI_STATUS} from '@/common/constants/httpStatus';

const handleInvalidXsrfToken: AfterResponseHook =
    async (request, options, response) => {

        if (response.status === HTTP_MULTI_STATUS) {
            notify({
                title: 'Approval Required',
                text: 'This action requires approval from an administrator',
                type: 'warn',
                duration: 7000,
            });
        }

        return response;
    };

export default handleInvalidXsrfToken;
