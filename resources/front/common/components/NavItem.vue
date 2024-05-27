<!--<script setup lang="ts">-->
<!--import {faChevronDown, IconDefinition} from '@fortawesome/free-solid-svg-icons';-->
<!--import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';-->
<!--import {Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue';-->
<!--import {computed} from 'vue';-->

<!--type menuLink = {-->
<!--    label: string,-->
<!--    href?: string,-->
<!--    icon: IconDefinition | null,-->
<!--    active?: boolean,-->
<!--    children?: menuLink[],-->
<!--}-->
<!--const props = defineProps<{-->
<!--    item: menuLink;-->
<!--}>();-->

<!--const hasActiveChild = computed(() => {-->
<!--    if (!props.item.children?.length) {-->
<!--        return false;-->
<!--    }-->

<!--    function hasActiveItem(items: menuLink[]): boolean {-->
<!--        return items.some(item => {-->
<!--            if (item.active) return true;-->
<!--            if (item.children?.length) {-->
<!--                hasActiveItem(item?.children);-->
<!--            }-->
<!--            return false;-->
<!--        });-->
<!--    }-->

<!--    return hasActiveItem(props.item?.children);-->
<!--});-->
<!--</script>-->
<!--<template>-->
<!--    <a-->
<!--        v-if="!props.item.children"-->
<!--        :class="[-->
<!--            'group flex w-full items-center rounded-md py-2 px-3 text-sm',-->
<!--            'hover:bg-gray-100',-->
<!--            // props.item.active ? 'font-semibold text-gray-800' : 'font-medium text-gray-600',-->
<!--        ]"-->
<!--        :href="props.item.href"-->
<!--    >-->
<!--        <component-->
<!--            :class="[-->
<!--                'mr-2 h-6 w-6 shrink-0 group-hover:text-gray-600',-->
<!--                // props.item.active ? 'text-gray-600' : 'text-gray-400',-->
<!--            ]"-->
<!--            :is="props.item.icon"-->
<!--            v-if="props.item.icon"-->
<!--        ></component>-->
<!--        <span>{{props.item.label}}</span>-->
<!--    </a>-->

<!--    <Disclosure-->
<!--        v-else-->
<!--        v-slot="{open}"-->
<!--        :default-open="hasActiveChild"-->
<!--    >-->
<!--        <DisclosureButton-->
<!--            class="'group flex w-full items-center rounded-md py-2 px-3 text-left text-sm',-->
<!--                'hover:bg-gray-100',"-->
<!--            :class="[-->
<!--                open ? 'font-semibold text-gray-800' : 'font-medium text-gray-600',-->
<!--            ]"-->
<!--        >-->
<!--            <component-->
<!--                :class="[-->
<!--                    'mr-2 h-6 w-6 shrink-0 group-hover:text-gray-600',-->
<!--                    // open ? 'text-gray-600' : 'text-gray-400',-->
<!--                ]"-->
<!--                :is="props.item.icon"-->
<!--                v-if="props.item.icon"-->
<!--            ></component>-->
<!--            <span class="flex-1">{{props.item.label}}</span>-->
<!--            <FontAwesomeIcon :icon="faChevronDown"-->
<!--                             :class="[-->
<!--                                 'h-6 w-6 shrink-0',-->
<!--                                 open ? '-rotate-180 text-gray-600' : 'text-gray-400',-->
<!--                             ]"-->
<!--            />-->
<!--        </DisclosureButton>-->

<!--        <DisclosurePanel class="ml-4">-->
<!--            <NavItem-->
<!--                v-for="(child,i) in item.children"-->
<!--                :item="child"-->
<!--                :key="i"-->
<!--            />-->
<!--        </DisclosurePanel>-->
<!--    </Disclosure>-->
<!--</template>-->
