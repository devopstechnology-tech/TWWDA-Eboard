<template>
    <Menu as="div">
        <MenuButton class="header-login-link">
            <FontAwesomeIcon :icon="faUserCircle" class="header-login"/>
            <FontAwesomeIcon :icon="faChevronDown" class="arrow-down"/>
            <FontAwesomeIcon :icon="faBars" class="header-hamburger"/>
        </MenuButton>
        <Transition
            enter-active-class="menu-enter-active"
            enter-from-class="menu-enter-from"
            enter-to-class="menu-enter-to"
            leave-active-class="menu-leave-active"
            leave-from-class="menu-leave-from"
            leave-to-class="menu-leave-to"
        >
            <MenuItems class="header-menu">
                <MenuButton class="nav-link">
                    <FontAwesomeIcon :icon="faClose" class="close-link fa-xl"/>
                </MenuButton>
                <MenuLinks :links="links" link-class="mobile-link"/>
                <RouterLink to="#" class="nav-link">
                    <span>My Account</span>
                </RouterLink>
                <button
                    v-if="authStore.isAuthenticated"
                    type="button"
                    class="nav-link logout-link"
                    @click="onLogout"
                >
                    <span>Log out</span>
                    <FontAwesomeIcon :icon="faSignOut" class="fa-md"/>
                </button>
            </MenuItems>
        </Transition>
    </Menu>
</template>

<script setup lang="ts">

import {faBars, faChevronDown, faClose, faSignOut} from '@fortawesome/free-solid-svg-icons';
import {faUserCircle} from '@fortawesome/free-solid-svg-icons/faUserCircle';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {Menu, MenuButton, MenuItems} from '@headlessui/vue';
import useLogoutRequest from '@/common/api/requests/useLogoutRequest';
import MenuLinks from '@/common/components/header/MenuLinks.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {LANDING} from '@/common/constants/customerRouteNames';
import useAuthStore from '@/common/stores/auth.store';
import router from '@/router';

const authStore = useAuthStore();
const handleUnexpectedError = useUnexpectedErrorHandler();

type RouterLinkProps = {
    name: string;
    to: string;
};
defineProps<{
    links: RouterLinkProps[];
}>();

async function onLogout() {
    try {
        await useLogoutRequest();

        authStore.setUser(undefined);

        await router.push({name: LANDING});
    } catch (err) {
        handleUnexpectedError(err);
    }
}

</script>
<style scoped>
.header-menu {
    @apply absolute right-0 mt-1 origin-top-right;
    @apply w-full overflow-hidden;
    @apply divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5;
    @apply focus:outline-none top-24;

    @apply lg:top-24;
    @apply sm:max-w-sm;

    .nav-link {
        @apply float-left clear-both w-full;
        @apply block py-2.5 px-4 font-semibold uppercase;
        @apply hover:bg-alt;

        img {
            @apply h-6;
        }
    }

    .mobile-link {
        @apply lg:hidden block;
    }

    .logout-link {
        @apply flex justify-between;

        img {
            @apply h-5;
        }
    }

    .close-link {
        @apply float-right clear-both;
    }

    .menu-hamburger {
        @apply inline-flex items-center justify-center p-2.5;
    }

    .menu-backdrop {
        @apply bg-black bg-opacity-25;
        @apply fixed inset-0 flex items-center justify-center p-4;
    }
}

.header-login-link {
    @apply flex items-center gap-3;

    .header-hamburger {
        @apply lg:hidden block h-6;
    }

    .arrow-down {
        @apply hidden lg:block h-3;
    }

    .header-login {
        @apply hidden lg:block h-6;
    }
}

.menu-enter-active {
    @apply transition duration-100 ease-out;
}

.menu-enter-from {
    @apply transform scale-95 opacity-0;
}

.menu-enter-to {
    @apply transform scale-100 opacity-100;
}

.menu-leave-active {
    @apply transition duration-75 ease-out;
}

.menu-leave-from {
    @apply transform scale-100 opacity-100;
}

.menu-leave-to {
    @apply transform scale-95 opacity-0;
}
</style>
