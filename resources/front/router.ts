import {createRouter, createWebHistory} from 'vue-router';
import useAuthStore from '@/common/stores/auth.store';
import staffRoutes from '@/staff/staffRoutes';
import useSettingsStore from '@/common/stores/settings.store';
import useMailTypesStore from '@/common/stores/mailtypes.store';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        ...staffRoutes,
    ],
});

router.beforeEach(async () => {
    // const authStore = useAuthStore();
    // await authStore.initialize();
    const authStore = useAuthStore();
    const settingsStore = useSettingsStore();
    const mailtypesStore = useMailTypesStore();
    await authStore.initialize(); 
    settingsStore.loadAndSaveSettings();
    mailtypesStore.loadAndSaveMailTypes();
});

export default router;
