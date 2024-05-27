import {defineStore} from 'pinia';
import {ref} from 'vue';

const usePaginationStore = defineStore('pagination', () => {
    const per_page = ref<number>(10);
    const current_page = ref<number>(1);
    const from =  ref<number>(0);
    const to =  ref<number>(0);
    const last_page =  ref<number>(0);
    const total = ref<number>(0);

    function setCurrentPage(page: number) {
        current_page.value = page;
    }
    function setPerPage(page: number) {
        per_page.value = page;
    }

    return {
        setCurrentPage,
        setPerPage,
        per_page,
        current_page,
        from,
        to,
        last_page,
        total,
    };
});

export default usePaginationStore;
