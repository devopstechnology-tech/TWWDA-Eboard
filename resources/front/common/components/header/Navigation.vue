<template>
    <header class="navigation">
        <nav>
            <div class="desktop-header">
                <RouterLink :to="{name: baseRoute}" class="header-logo">
                    <img src="@assets/images/logo.svg" alt="Sentry Falcon Logo">
                </RouterLink>

                <div v-if="authStore.isAuthenticated" class="desktop-header-menu">
                    <MenuLinks :links="links"/>
                </div>
            </div>
            <RouterLink :to="{name: LOGIN}" class="header-login-link" v-if="!authStore.isAuthenticated">
                <FontAwesomeIcon :icon="faUserCircle" class="fa-xl"/>
                <span>Log in</span>
            </RouterLink>
            <Menu :links="links" v-else/>
        </nav>
    </header>
</template>

<script lang="ts" setup>
import {faUserCircle} from '@fortawesome/free-solid-svg-icons/faUserCircle';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import Menu from '@/common/components/header/Menu.vue';
import MenuLinks from '@/common/components/header/MenuLinks.vue';
import {LOGIN} from '@/common/constants/customerRouteNames';
import useAuthStore from '@/common/stores/auth.store';

type RouterLinkProps = {
    name: string;
    to: string;
};
defineProps<{
    links: RouterLinkProps[];
    baseRoute: symbol;
}>();
const authStore = useAuthStore();

</script>
<style scoped>
.navigation {
    @apply bg-gray-200 px-5;

    nav {
        @apply mx-auto flex flex-wrap items-center justify-between p-3;

        .header-logo {
            @apply p-1.5 flex;

            img {
                @apply w-32;
            }
        }

        .header-login-link {
            @apply flex flex-row justify-end items-center gap-3;
        }

        .desktop-header {
            @apply flex-1 flex items-center;
        }

        .desktop-header-menu {
            @apply inline-block hidden;
            @apply gap-3;
            @apply ml-10;

            @apply lg:flex;

            .nav-link {
                @apply float-left clear-both;
                @apply block py-2.5 px-4 font-semibold;
                @apply uppercase;
            }
        }
    }
}
</style>
