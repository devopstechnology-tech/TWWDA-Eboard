<script setup lang="ts">
import {faHome, faNewspaper, faPhotoFilm, IconDefinition} from '@fortawesome/free-solid-svg-icons';
// import Logo from '../components/Logo.vue';
import NavItem from '../components/NavItem.vue';

type menuLink = {
    label: string,
    href?: string,
    icon: IconDefinition | null,
    active?: boolean,
    children: menuLink[] | [],
}

const navItems: menuLink[] = [
    {href: '#', active: false, label: 'Home', children: [], icon: faHome},
    {
        href: '#', active: false,
        label: 'Posts',
        children: [
            {href: '#', active: false, label: 'All posts', children: [], icon: null},
            {href: '#', active: false, label: 'Add new', children: [], icon: null},
            {href: '#', active: false, label: 'Categories', children: [], icon: null},
        ],
        icon: faNewspaper,
    },
    {
        href: '#', active: false,
        label: 'Media',
        children: [
            {href: '#', active: false, label: 'Library', children: [], icon: null},
            {
                href: '#', active: false,
                label: 'Add new',
                children: [{href: '#', active: false, label: 'Third level', children: [], icon: null}],
                icon: null,
            },
        ],
        icon: faPhotoFilm,
    },
];
</script>
<template>
    <div class="flex min-h-screen">
        <div class="w-64 shrink-0 border-r border-gray-200 bg-gray-50 py-4">
            <div class="px-4">
                <a
                    href="#"
                    class="inline-block"
                >
                    <!--                    <Logo class="h-8 w-auto"/>-->
                </a>
            </div>

            <nav class="mt-2 px-2">
                <NavItem
                    :item="item"
                    v-for="(item,i) in navItems"
                    :key="i"
                />
            </nav>
        </div>

        <main class="p-4">content</main>
    </div>
</template>
