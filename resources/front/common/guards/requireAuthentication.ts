import {NavigationGuard} from 'vue-router';
import {LOGIN} from '@/common/constants/customerRouteNames';
import useAuthStore from '@/common/stores/auth.store';

const requireAuthentication: NavigationGuard = to => {
    const authStore = useAuthStore();

    if (!authStore.isAuthenticated) {
        authStore.setIntendedRoute(to);

        return {name: LOGIN};
    }
};

export default requireAuthentication;
