import {defineStore} from 'pinia';
import {ref} from 'vue';

const useMetaStore = defineStore('meta', () => {
    const appData = document.getElementById('app')?.dataset;
    const appUrl = ref<string>();
    const initialized = ref<boolean>(false);

    function initialize() {
        if (initialized.value) {
            return;
        }

        if (!appData?.appUrl) {
            throw new Error('App URL is not defined.');
        }

        appUrl.value = appData.appUrl;

        initialized.value = true;
    }

    return {
        appUrl,
        debug: import.meta.env.DEV,
        initialize,
        initialized,
    };
});

export default useMetaStore;
