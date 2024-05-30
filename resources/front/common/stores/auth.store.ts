import {defineStore} from 'pinia';
import {computed, ref} from 'vue';
import {RouteLocationNormalized} from 'vue-router';
import useCurrentAuthRequest from '@/common/api/requests/useCurrentAuthRequest';
import {LOGIN} from '@/common/constants/customerRouteNames';
import {LOCAL_USER} from '@/common/constants/localStorageKeys';
import {AuthenticatedUser} from '@/common/parsers/userParser';
import {isError} from '@/common/utilities/isError';

const useAuthStore = defineStore('auth', () => {
    const checkController = ref<AbortController>();
    const initialized = ref(false);
    const intendedRoute = ref<RouteLocationNormalized>();
    const user = ref<AuthenticatedUser>();

    const isAuthenticated = computed(() => !!user.value);

    const mainRoute = computed(() => {
        return {name: LOGIN};
    });

    function setUser(newUser?: AuthenticatedUser) {
        user.value = newUser;
        if (newUser) {
            localStorage.setItem(LOCAL_USER, JSON.stringify(newUser));
        } else {
            localStorage.removeItem(LOCAL_USER);
        }
    }

    async function updateProfile() {
        checkController.value?.abort();
        checkController.value = new AbortController();
        const currentUser = await useCurrentAuthRequest({
            signal: checkController.value?.signal,
        });
        setUser(currentUser);
    }

    async function check() {
        checkController.value?.abort();
        checkController.value = new AbortController();
        const currentUser = await useCurrentAuthRequest({
            signal: checkController.value?.signal,
        });
        setUser(currentUser);
    }

    function hasPermission(permissions: string | string[]): boolean {
        if (user.value?.role === 'Super Admin') {
            return true;
        }
        if (Array.isArray(permissions)) {
            return permissions.some(permission =>
                user.value?.permissions?.some(p => p.name === permission),
            );
        }
        return user.value?.permissions?.some(p => p.name === permissions) || false;
    }

    function hasRole(roles: string | string[]): boolean {
        if (user.value?.role === 'Super Admin') {
            return true;
        }
        if (Array.isArray(roles)) {
            return roles.includes(user.value?.role || '');
        }
        return roles === user.value?.role;
    }

    function hasAllPermissions(permissions: string[]): boolean {
        return permissions.every(permission => hasPermission(permission));
    }

    async function initialize() {
        if (initialized.value) {
            return;
        }

        const storedUser = localStorage.getItem(LOCAL_USER);
        if (storedUser) {
            setUser(JSON.parse(storedUser));
        } else {
            await check();
        }

        initialized.value = true;
    }

    return {
        hasAllPermissions,
        hasPermission,
        hasRole,
        initialize,
        intendedRoute,
        isAuthenticated,
        mainRoute,
        setIntendedRoute: (route?: RouteLocationNormalized) => {
            intendedRoute.value = route;
        },
        setUser,
        updateProfile,
        user,
    };
});

export default useAuthStore;
