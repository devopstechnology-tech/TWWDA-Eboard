<script lang="ts" setup>
import {faAngleDoubleLeft, faAngleDoubleRight, faAngleLeft, faAngleRight} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {computed, ref} from 'vue';
import {PaginationMeta} from '@/common/parsers/paginatedParser';
import determinePaginationPages from '@/common/utilities/determinePaginationPages';

const props = defineProps<{
    meta: PaginationMeta;
}>();


const distanceFromCurrent = ref(4);

const pages = computed(() => determinePaginationPages(
    props.meta,
    distanceFromCurrent.value,
));

const pageLinks = computed(() => pages.value.map(page => !page ? undefined : {
    active: page === props.meta.current_page,
    number: page,
}));

const renderedPageCount = computed(() => pageLinks.value.length);
const emit = defineEmits(['next', 'previous', 'page']);
</script>

<template>
    <div class="pagination" v-if="meta.last_page !== 1">
        <div class="previous-options">
            <button class="page first text-blue-400" @click="emit('previous')" v-if="props.meta.current_page ===1">
                <FontAwesomeIcon :icon="faAngleDoubleLeft"/>
            </button>
            <span class="page first disabled" v-else>
                <FontAwesomeIcon :icon="faAngleDoubleLeft"/>
            </span>
            <button class="page previous text-blue-400" @click="emit('previous')" v-if="props.meta.current_page >1">
                <FontAwesomeIcon :icon="faAngleLeft"/>
                <span>Previous</span>
            </button>
            <span class="page previous disabled" v-else>
                <FontAwesomeIcon :icon="faAngleLeft"/>
                <span>Previous</span>
            </span>
        </div>
        <div class="pages">
            <template v-for="(link, index) in pageLinks">
                <button
                    :key="`page-${link.number}`"
                    :class="['page', {active: link.active}]"
                    @click="emit('page',link.number)"
                    v-if="link"
                >
                    {{link.number}}
                </button>
                <span :key="`gap-${index}`" class="page gap" v-else>...</span>
            </template>
        </div>
        <div class="next-options">
            <button class="page next text-blue-400" @click="emit('next')" v-if="props.meta.last_page !==
                props.meta.current_page">
                <span>Next</span>
                <FontAwesomeIcon :icon="faAngleRight"/>
            </button>
            <span class="page next disabled" v-else>
                <span>Next</span>
                <FontAwesomeIcon :icon="faAngleRight"/>
            </span>
            <button class="page last text-blue-400" @click="emit('next')"
                    v-if="props.meta.current_page === props.meta.last_page">
                <FontAwesomeIcon :icon="faAngleDoubleRight"/>
            </button>
            <span class="page last disabled" v-else>
                <FontAwesomeIcon :icon="faAngleDoubleRight"/>
            </span>
        </div>
    </div>
</template>

<style scoped>
.pagination {
    @apply border-t border-t-gray-300;
    @apply flex items-center;
    @apply text-sm;
}

.page {
    @apply border-y-2 border-transparent;
    @apply flex gap-2 items-center justify-center;
    @apply leading-none text-center;
    @apply px-4 py-2;

    &.active {
        @apply border-t-blue-800;
    }

    &.disabled {
        @apply text-alt;
    }
}

a.page {
    @apply hover:border-t-blue-900;
}

.page.first, .page.last {
    @apply sm:hidden;
}

.page.next, .page.previous {
    & > span {
        @apply hidden md:inline;
    }
}

.next-options {
    @apply flex flex-1 justify-end;
}

.previous-options {
    @apply flex flex-1 justify-start;
}

.pages {
    @apply sm:grid;

    grid-template-columns: repeat(v-bind(renderedPageCount), 1fr);

    & > .page:not(.active) {
        @apply hidden sm:block;
    }
}
</style>
