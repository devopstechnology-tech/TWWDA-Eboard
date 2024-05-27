<template>
    <RouterLink
        v-for="item in links"
        :to="item.to"
        exact
        :class="['nav-link', linkClass,item.name=='Sign Up'?'login':'']"
        :key="item.name"
    >
        {{ item.name }}
    </RouterLink>
</template>

<script lang="ts" setup>
defineProps<{
    linkClass?: string;
    links: RouterLinkProps[];
}>();

type RouterLinkProps = {
    name: string;
    to: string;
};

</script>

<style scoped>

.nav-link {
    @apply float-left clear-both;
    @apply block py-1.5 font-medium lg:text-left text-center;
    @apply lg:mx-4 mb-1;
    @apply uppercase text-gray-500;

    @apply hover:text-secondary uppercase;
}

.router-link-exact-active {
    @apply lg:border-b-4  text-blue-primary border-blue-light;
}

.mobile-link {
    @apply lg:hidden block mx-4;
}

.login {
    @apply lg:bg-blue-light text-white lg:px-4 px-4 justify-center rounded-md bg-blue-primary flex
    items-center;
}

</style>
