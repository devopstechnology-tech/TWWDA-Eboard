import Cookies from 'js-cookie';
import {BeforeRequestHook} from 'ky';
import {LOCAL_TOKEN} from '@/common/constants/localStorageKeys';

const injectXsrfToken: BeforeRequestHook = request => {
    const token = Cookies.get('XSRF-TOKEN');
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    const bearerToken = localStorage.getItem(LOCAL_TOKEN);
    // if (token) {
    if (typeof token === 'string') {
        request.headers.set('X-XSRF-TOKEN', token);
    }
    request.headers.append('Authorization', `Bearer ${bearerToken}`);
    // }

    return request;
};

export default injectXsrfToken;
