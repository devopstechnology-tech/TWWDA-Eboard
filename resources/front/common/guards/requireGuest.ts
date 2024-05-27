import {NavigationGuard} from 'vue-router';
import useAuthStore from '@/common/stores/auth.store';

const requireGuest: NavigationGuard = () => {
    const authStore = useAuthStore();

    if (authStore.isAuthenticated) {
        // return {name: DASHBOARD};
    }
};

export default requireGuest;
