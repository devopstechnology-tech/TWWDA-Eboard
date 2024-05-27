import {notify} from '@kyvg/vue3-notification';
import {BeforeErrorHook} from 'ky';
import {HTTP_CONFLICT, HTTP_UNAUTHORIZED} from '@/common/constants/httpStatus';
import authStore from '@/common/stores/auth.store';

const handleErrors: BeforeErrorHook = async error => {
    // console.log(error.response.body.message);
    if (error.response.status === HTTP_CONFLICT) {
        const disp = await error.response.json();
        notify({
            title: 'Conflict',
            text: disp.message,
            type: 'warn',
            duration: 7000,
        });
    }
    const authstore = authStore();
    if (error.response.status === HTTP_UNAUTHORIZED) {
        authstore.setUser(undefined);
        // await router.push({name: STAFF_MAIN});
    }

    return error;
};
export default handleErrors;
