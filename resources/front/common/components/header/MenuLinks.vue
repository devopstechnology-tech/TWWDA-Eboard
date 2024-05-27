<template>
    <RouterLink
        v-for="item in links"
        :to="item.to"
        exact
        :class="['nav-link', linkClass]"
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
    @apply block py-2.5 px-4 font-semibold;
    @apply uppercase;

    @apply hover:bg-alt uppercase;
}

.mobile-link {
    @apply lg:hidden block;
}

</style>
