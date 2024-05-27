import {defineStore} from 'pinia';
import {ref} from 'vue';

const useLoadingStore = defineStore('loading', () => {
    const loading = ref(false);

    function setLoading(data: boolean) {
        loading.value = data;
    }

    return {
        setLoading,
        loading,
    };
});

export default useLoadingStore;
