<template>
    <div class="w-full px-2 py-16 sm:px-0 text-black">
        <TabGroup>
            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
                <Tab
                    v-for="category in Object.keys(categories)"
                    as="template"
                    :key="category"
                    v-slot="{ selected }"
                >
                    <button
                        :class="[
                            'w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-blue-700',
                            'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400' +
                                ' focus:outline-none focus:ring-2',
                            selected
                                ? 'bg-white shadow'
                                : 'text-blue-100 hover:bg-white/[0.12] hover:text-white',
                        ]"
                    >
                        {{category}}
                    </button>
                </Tab>
            </TabList>

            <TabPanels class="mt-2">
                <TabPanel
                    :class="[
                        'rounded-xl bg-gray-300 p-3',
                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                    ]"
                >
                    <div class="py-2 w-full px-2">
                        <!-- Card -->
                        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                            <div class="mb-8">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                    Daily Parking
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Pay for your daily or street parking
                                </p>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                </TabPanel>
                <TabPanel :class="[
                    'rounded-xl bg-gray-300 p-3',
                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">fsdf
                </TabPanel>
                <TabPanel :class="[
                    'rounded-xl bg-gray-300 p-3',
                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">xcvxcv
                </TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>

<script setup lang="ts">
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue';
import {ref} from 'vue';

const categories = ref({
    'Daily/Street Parking': [
        {
            id: 1,
            title: 'Does drinking coffee make you smarter?',
            date: '5h ago',
            commentCount: 5,
            shareCount: 2,
        },
        {
            id: 2,
            title: "So you've bought coffee... now what?",
            date: '2h ago',
            commentCount: 3,
            shareCount: 2,
        },
    ],
    'Seasonal Parking (stickers)': [
        {
            id: 1,
            title: 'Is tech making coffee better or worse?',
            date: 'Jan 7',
            commentCount: 29,
            shareCount: 16,
        },
        {
            id: 2,
            title: 'The most innovative things happening in coffee',
            date: 'Mar 19',
            commentCount: 24,
            shareCount: 12,
        },
    ],
    'Reserved Parking': [
        {
            id: 1,
            title: 'Ask Me Anything: 10 answers to your questions about coffee',
            date: '2d ago',
            commentCount: 9,
            shareCount: 5,
        },
        {
            id: 2,
            title: "The worst advice we've ever heard about coffee",
            date: '4d ago',
            commentCount: 1,
            shareCount: 2,
        },
    ],
});
</script>
