import {NavigationGuard} from 'vue-router';
import {DASHBOARD} from '@/common/constants/staffRouteNames';
import useAuthStore from '@/common/stores/auth.store';

const requireStaffGuest: NavigationGuard = () => {
    const authStore = useAuthStore();

    if (authStore.isAuthenticated) {
        return {name: DASHBOARD};
    }
};

export default requireStaffGuest;
