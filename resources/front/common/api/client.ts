import ky, {Options} from 'ky';
import handleErrors from '@/common/api/hooks/handleErrors';
import handleInvalidXsrfToken from '@/common/api/hooks/handleInvalidXsrfToken';
import handleResponse from '@/common/api/hooks/handleResponse';
import handleValidationError from '@/common/api/hooks/handleValidationError';
import injectXsrfToken from '@/common/api/hooks/injectXsrfToken';
import useMetaStore from '@/common/stores/meta.store';

export default function useClient(options: Options = {}) {
    const metaStore = useMetaStore();

    if (!metaStore.appUrl) {
        throw new Error('Cannot create API client without appUrl.');
    }

    return ky.create({
        hooks: {
            afterResponse: [handleInvalidXsrfToken, handleResponse],
            beforeError: [handleValidationError, handleErrors],
            beforeRequest: [injectXsrfToken],
        },
        prefixUrl: metaStore.appUrl,
        retry: {
            statusCodes: [408, 413, 429, 502, 503, 504],
        },
    }).extend(options);
}
