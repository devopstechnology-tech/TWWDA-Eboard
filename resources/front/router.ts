import {createRouter, createWebHistory} from 'vue-router';
import {LOGIN} from '@/common/constants/staffRouteNames';
import useAuthStore from '@/common/stores/auth.store';
import useMailTypesStore from '@/common/stores/mailtypes.store';
import useSettingsStore from '@/common/stores/settings.store';
import staffRoutes from '@/staff/staffRoutes';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        ...staffRoutes,
    ],
});
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();
    const settingsStore = useSettingsStore();
    const mailtypesStore = useMailTypesStore();    
    try {
        await authStore.initialize();
        await settingsStore.loadAndSaveSettings();
        await mailtypesStore.loadAndSaveMailTypes();
        next();
    } catch (error) {
        next();
    }
});


export default router;
