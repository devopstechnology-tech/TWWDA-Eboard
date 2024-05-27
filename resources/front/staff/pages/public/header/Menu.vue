<template>
    <Menu as="div" class="z-10 menu">
        <MenuButton class="header-login-link">
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
            </MenuItems>
        </Transition>
    </Menu>
</template>

<script setup lang="ts">

import {faBars, faClose} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {Menu, MenuButton, MenuItems} from '@headlessui/vue';
import MenuLinks from './MenuLinks.vue';

type RouterLinkProps = {
    name: string;
    to: string;
};
defineProps<{
    links: RouterLinkProps[];
}>();

</script>
<style scoped>

.header-menu {
    @apply absolute right-0 mt-1 origin-top-right;
    @apply w-full overflow-hidden;
    @apply lg:hidden block;
    @apply divide-gray-100 rounded-b-md bg-white shadow-lg ring-1 ring-black ring-opacity-5;
    @apply focus:outline-none top-16;

    @apply lg:top-16;
    @apply sm:max-w-sm;

    .nav-link {
        @apply float-left clear-both w-full;
        @apply block py-2.5 px-4 font-semibold uppercase;
        @apply hover:bg-gray-50;

        img {
            @apply h-6;
        }
    }

    .mobile-link {
        @apply lg:hidden block;
        @apply px-4 mx-4;
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
    @apply flex items-center justify-between gap-3;

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
