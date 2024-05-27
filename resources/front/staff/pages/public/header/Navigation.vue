<template>
    <header class="navigation">
        <nav>
            <div class="desktop-header">
                <RouterLink to="/" class="header-logo">
                    <img src="@assets/images/logo.svg" alt="EREV logo">
                </RouterLink>

                <div class="desktop-header-menu">
                    <MenuLinks :links="links"/>
                </div>
            </div>
            <Menu :links="links"/>
        </nav>
    </header>
</template>

<script lang="ts" setup>
import Menu from './Menu.vue';
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
.navigation {
    @apply px-5 bg-gray-100;

    nav {
        @apply flex flex-wrap flex-1 items-center justify-between lg:px-10;

        .header-logo {
            @apply lg:p-1.5 flex;

            img {
                @apply w-16;
            }
        }

        .header-login-link {
            @apply flex flex-row justify-center items-center gap-3;
        }

        .desktop-header {
            @apply flex-1 flex items-center justify-between;
        }

        .desktop-header-menu {
            @apply inline-block hidden;
            @apply gap-3;
            @apply ml-10;

            @apply lg:flex lg:items-center;

            .nav-link {
                @apply float-left clear-both;
                @apply block py-2.5 px-4 font-thin;
                @apply uppercase;
            }

            a {
                @apply bg-blue-primary text-white text-center flex items-center;
                @apply px-5;
                @apply rounded-lg;
            }
        }
    }
}
</style>
