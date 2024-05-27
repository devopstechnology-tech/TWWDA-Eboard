import {useRouter} from 'vue-router';
import {Permission} from '@/common/parsers/permissionParser';
import useAuthStore from '@/common/stores/auth.store';

export default function usePermissionGuard(permissions: Permission[]) {
    const authStore = useAuthStore();
    const router = useRouter();
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore
    if (!authStore.hasAllPermissions(permissions)) {
        router.push('/login');
        // throw new ForbiddenError(permissions);
    }
}
