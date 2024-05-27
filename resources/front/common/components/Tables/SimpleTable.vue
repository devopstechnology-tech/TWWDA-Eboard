<template>
    <div class="card rounded" :class="[bgColor]">
        <div class="my-6">
            <h2 class="card-title">{{title}}</h2>
            <div v-if="!loading.loading" class="">
                <div v-if="records.length > 0" class="p-2 flex flex-col">
                    <div class="flex flex-col lg:flex-row md:justify-between gap-2 mb-2">
                        <div class="flex gap-2 items-center">
                            <button @click.prevent="$emit('onCreate')"
                                    v-if="crud"
                                    class="button">
                                <FontAwesomeIcon :icon="faPlus"/>
                                <span class="hidden md:inline">
                                    {{languages.newRecordButtonText}}
                                </span>
                            </button>
                            <input v-model="filterInputValue" @keyup.prevent="filterRecords" type="text"
                                   :placeholder="languages.filterInputPlaceHolderText"
                                   class="search">
                        </div>
                        <div class="header-actions">
                            <div class="flex gap-2 items-center">

                                <div class="relative">
                                    <Dropdown classes="w-44 p-2 border right-0">
                                        <span class="showPageSelect">
                                            <FontAwesomeIcon :icon="faEye"/>
                                        </span>
                                        <template v-slot:items>
                                            <ul class="flex flex-col gap-2">
                                                <li>
                                                    <a @click.prevent="hiddenColumns.length = 0" href="#"
                                                       :class="{'bg-sky-500 ':hiddenColumns.length === 0}"
                                                       class="inline-block p-2 w-full rounded bg-primary">
                                                        <FontAwesomeIcon :icon="faEye"/>
                                                        {{languages.seeAllColumnsText}}
                                                    </a>
                                                </li>
                                                <li v-for="columnName in columnNames" :key="columnName.name">
                                                    <a @click.prevent="toggleHiddenColumn(columnName.real)"
                                                       :class="[
                                                           !hiddenColumns.includes(columnName.real)?
                                                               'bg-sky-500':
                                                               'bg-gray-300'
                                                       ]"
                                                       href="#"
                                                       class="inline-block p-2 w-full rounded">{{columnName.name}}</a>
                                                </li>
                                            </ul>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                            <div class="gap-2 hidden">
                                <button class="btn btn-sm bg-gray-400/40">
                                    <FontAwesomeIcon :icon="faDownload"/>
                                    PDF
                                </button>
                                <button class="btn btn-sm bg-gray-400/40">
                                    <FontAwesomeIcon :icon="faDownload"/>
                                    XLS
                                </button>
                                <button class="btn btn-sm bg-gray-400/40">
                                    <FontAwesomeIcon :icon="faDownload"/>
                                    CSV
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-auto border mb-2 bg-gray-100">
                        <div class="lg:hidden flex flex-col px-6 rounded-lg">
                            <div
                                class="card bg-blue-300 text-primary-content overflow-auto my-2"
                                v-for="(record, index) in
                                    datatableRecords"
                                :key="index">
                                <div class="card-body">
                                    <div class="text-left gap-2 flex flex-col">
                                        <div :class="{'hidden':hiddenColumns.includes(columnName.real)}"
                                             class="font-semibold text-xs"
                                             v-for="columnName in columnNames" :key="columnName.real"
                                             v-show="!exceptColumns!.includes(columnName.real)">
                                            <div class="flex items-center justify-between gap-6 ">
                                                <div> {{columnName.name}}:</div>
                                                <div v-if="typeof  record[columnName.real as keyof
                                                    typeof record]!=='object' || record[columnName.real as keyof
                                                    typeof record]==null" class="">
                                                    {{
                                                        cellFormatter(
                                                            record[columnName.real as keyof typeof record])
                                                    }}
                                                </div>

                                                <button class="btn btn-accent btn-xs" v-else
                                                        @click.prevent="viewData(record[columnName.real as keyof
                                                            typeof record])">
                                                    View Data
                                                </button>

                                            </div>
                                        </div>
                                        <div class="flex justify-between font-semibold text-xs"
                                             v-if="menuItems && menuItems.length>0">
                                            <div> Actions:</div>
                                            <span class="flex gap-2 items-center">
                                                <span v-if="menuItems.some(e=>e.name==='Edit')">
                                                    <button class=" rounded-md btn-xs bg-blue-500/40"
                                                            @click.prevent="emit('onEdit', record)">
                                                        <span class="hidden">Edit</span>
                                                        <FontAwesomeIcon :icon="faPencil"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='Delete')">
                                                    <button class="rounded-md btn-xs bg-gray-600/40"
                                                            @click.prevent="emit('onDelete', record)">
                                                        <span class="hidden">Delete</span>
                                                        <FontAwesomeIcon :icon="faTrash"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems!.some(e=>e.name==='PayAgain')">
                                                    <button class="action-button"
                                                            @click.prevent="emit('onRenew', record)">
                                                        <span class="hidden">Renew</span>
                                                        <FontAwesomeIcon :icon="faMoneyBill"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='Pay')">
                                                    <button class="action-button"
                                                            @click.prevent="emit('onPay', record)">
                                                        <span class="hidden">Pay</span>
                                                        <FontAwesomeIcon :icon="faMoneyBill"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='Cart')">
                                                    <button class="action-button"
                                                            @click.prevent="emit('onAddToCart', record)">
                                                        <span class="hidden">Add To Cart</span>
                                                        <FontAwesomeIcon :icon="faShoppingBasket"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='Reprint')">
                                                    <button class="action-button"
                                                            @click.prevent="emit('onReprint', record)">
                                                        <span class="hidden">Print</span>
                                                        <FontAwesomeIcon :icon="faPrint"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='Approve')">
                                                    <button class="btn btn-xs btn-success text-black"
                                                            @click.prevent="emit('onApprove', record)">
                                                        <span class="">Approve</span>
                                                        <FontAwesomeIcon :icon="faCheck" class="fa-2xs"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='Disapprove')">
                                                    <button class="btn btn-xs btn-error text-black"
                                                            @click.prevent="emit('onDisapprove', record)">
                                                        <span class="">Disapprove</span>
                                                        <FontAwesomeIcon :icon="faClose" class="fa-2xs"/>
                                                    </button>
                                                </span>
                                                <span v-if="menuItems.some(e=>e.name==='View')">
                                                    <button class="action-button"
                                                            @click.prevent="emit('onView', record)">
                                                        <span class="">View</span>
                                                        <FontAwesomeIcon :icon="faEye"/>
                                                    </button>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:flex lg:flex-col">
                            <table
                                class="table-xs table-auto w-full text-center">
                                <thead class="dark:bg-gray-500 bg-gray-300">
                                    <tr class="">
                                        <slot v-for="(columnName, index) in columnNames"
                                              :name="`header_${columnName.real}`"
                                              :class="{'hidden':hiddenColumns.includes(columnName.real)}"
                                              :header="columnName">
                                            <th :key="index"
                                                class="text-xs uppercase "
                                                :class="{'hidden':hiddenColumns.includes(columnName.real)}">
                                                <div class="flex gap-2 items-center justify-center">
                                                    <span @click="sortRecords(columnName.real)"
                                                          class="hover:text-gray-400 cursor-pointer">
                                                        {{columnName.name}}
                                                        <FontAwesomeIcon
                                                            v-if="sortDirection === 'asc'
                                                                && sortColumnName === columnName.real"
                                                            :icon="faSortDown"
                                                            class="ml-1"
                                                        />
                                                        <FontAwesomeIcon
                                                            v-else-if="sortDirection === 'desc'
                                                                && sortColumnName === columnName.real"
                                                            :icon="faSortUp"
                                                            class="ml-1"
                                                        />
                                                    </span>
                                                </div>
                                            </th>
                                        </slot>
                                        <slot name="header.action" v-if="menuItems && menuItems.length>0">
                                            <th class="text-xs uppercase text-center">
                                                Actions
                                            </th>
                                        </slot>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-400">
                                    <tr v-for="(record, index) in datatableRecords"
                                        :class="{'bg-gray-300':index % 2 !== 0}"
                                        :key="index" class="">
                                        <slot :class="{'hidden':hiddenColumns.includes(columnName.real)}"
                                              :name="`column_${columnName.real}`"
                                              v-for="columnName in columnNames" :key="columnName.real"
                                        >
                                            <td v-show="!exceptColumns!.includes(columnName.real)"
                                                class="p-2"
                                                :class="{'hidden':hiddenColumns.includes(columnName.real)}"
                                                :key="columnName.real">
                                                <span v-if="typeof  record[columnName.real as keyof
                                                    typeof record]!=='object' || record[columnName.real as keyof
                                                    typeof record]==null">
                                                    {{
                                                        cellFormatter(record[columnName.real as keyof typeof record])
                                                    }}
                                                </span>

                                                <button class="btn btn-accent btn-xs" v-else
                                                        @click.prevent="viewData(record[columnName.real as keyof
                                                            typeof record])">
                                                    View Data
                                                </button>

                                            </td>
                                        </slot>
                                        <slot name="actions" :record="record" v-if="menuItems && menuItems.length>0">
                                            <td class="px-0.5">
                                                <span class="flex gap-2 justify-center items-center">
                                                    <span v-if="menuItems.some(e=>e.name==='Edit')">
                                                        <button class="action-button"
                                                                @click.prevent="emit('onEdit', record)">
                                                            <span class="">Edit</span>
                                                            <FontAwesomeIcon :icon="faPencil"
                                                                             class="hidden xl:flex"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='Delete')">
                                                        <button class="action-button"
                                                                @click.prevent="emit('onDelete', record)">
                                                            <span class="">Delete</span>
                                                            <FontAwesomeIcon :icon="faTrash" class="hidden xl:flex"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems!.some(e=>e.name==='PayAgain')">
                                                        <button class="action-button"
                                                                @click.prevent="emit('onRenew', record)">
                                                            <span class="">Renew</span>
                                                            <FontAwesomeIcon :icon="faMoneyBillTrendUp"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='Pay')">
                                                        <button class="action-button"
                                                                @click.prevent="emit('onPay', record)">
                                                            <span class="hidden">Pay</span>
                                                            <FontAwesomeIcon :icon="faMoneyBill"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='Cart')">
                                                        <button class="action-button"
                                                                @click.prevent="emit('onAddToCart', record)">
                                                            <span class="hidden">Add To Cart</span>
                                                            <FontAwesomeIcon :icon="faShoppingBasket"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='Reprint')">
                                                        <button
                                                            class="action-button"
                                                            @click.prevent="emit('onReprint', record)">
                                                            <span class="">Print</span>
                                                            <FontAwesomeIcon :icon="faPrint"
                                                                             class="hidden xl:flex"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='Approve')">
                                                        <button class="btn btn-xs btn-success text-black"
                                                                @click.prevent="emit('onApprove', record)">
                                                            <FontAwesomeIcon :icon="faCheck" class="fa-2xs"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='Disapprove')">
                                                        <button class="btn btn-xs btn-error text-black"
                                                                @click.prevent="emit('onDisapprove', record)">
                                                            <span class="hidden">Disapprove</span>
                                                            <FontAwesomeIcon :icon="faClose" class="fa-2xs"/>
                                                        </button>
                                                    </span>
                                                    <span v-if="menuItems.some(e=>e.name==='View')">
                                                        <button class="action-button"
                                                                @click.prevent="emit('onView', record)">
                                                            <span class="">View</span>
                                                            <FontAwesomeIcon
                                                                :icon="faEye" class="hidden xl:flex"/>
                                                        </button>
                                                    </span>
                                                </span>
                                            </td>
                                        </slot>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-between gap-12">
                        <div class="flex justify-between items-center gap-6"
                             v-if="paginate && props.meta && props.meta.last_page !== 1">
                            <div class="text-xs">
                                Showing {{
                                    props.meta?.per_page < props.meta?.total ? props.meta?.per_page :
                                    props.meta?.total
                                }} of {{props.meta?.total}}
                            </div>
                            <div class="flex">
                                <Dropdown classes="w-28 border">
                                    <span class=" px-2 h-7 items-center flex justify-between
                                    rounded bg-gray-200 hover:bg-gray-300 text-gray-500 gap-1">
                                        <span class="text-xs">Items per page: {{props.meta?.per_page ?? 15}} </span>
                                        <FontAwesomeIcon :icon="faChevronDown" class="fa-xs"/>
                                    </span>
                                    <template v-slot:items>
                                        <ul
                                            class="flex flex-col items-center justify-center  gap-1
                                        divide-y divide-yellow-400">
                                            <template v-for="i in 20" :key="i">
                                                <li v-if="i%5==0"
                                                    class="bg-gray-300 self-stretch px-6 text-right
                                            hover:bg-gray-400 "
                                                    @click.prevent="emit('perPage',i)">
                                                    {{i}}
                                                </li>
                                            </template>
                                            <li class="bg-gray-300 self-stretch px-6 text-right
                                            hover:bg-gray-400 "
                                                @click.prevent="()=>{
                                                    emit('page',1)
                                                    emit('perPage',props.meta?.total)
                                                }"
                                            >
                                                All
                                            </li>
                                        </ul>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                        <div class="flex">
                            <Pagination v-if="paginate && props.meta"
                                        :meta="props.meta"
                                        @next="nextPage"
                                        @page="setPage"
                                        @previous="previousPage"/>
                        </div>

                    </div>
                </div>
                <div v-else class="flex flex-col gap-4 items-center mt-6">
                    <div v-if="crud" class="">
                        <p>No data available</p>
                        <button @click.prevent="emit('onCreate')"
                                class="button">
                            <FontAwesomeIcon :icon="faPlus"/>
                            {{languages.newRecordButtonText}}
                        </button>
                    </div>
                    <div v-else>
                        <p>No data available</p>
                        <button class="button"
                                @click="emit('refresh')">
                            <FontAwesomeIcon :icon="faRefresh"/>
                            Refresh
                        </button>
                    </div>
                    <Alert>
                        <span>{{languages.alertMessage}}</span>
                    </Alert>
                </div>
                <dialog id="my_modal_1" class="modal" ref="modal">
                    <form method="dialog" class="modal-box">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        <h3 class="font-bold text-lg">Data Changes</h3>
                        <vue-json-pretty :data="modalData!"/>
                    </form>
                </dialog>
            </div>
            <LoadingComponent color="text-red-700" v-else/>
        </div>
    </div>

</template>

<script setup lang="ts">
import 'vue-json-pretty/lib/styles.css';
import {
    faCheck,
    faChevronDown,
    faClose,
    faDownload,
    faEye,
    faMoneyBill,
    faMoneyBillTrendUp,
    faPencil,
    faPlus,
    faPrint,
    faRefresh,
    faShoppingBasket,
    faSortDown,
    faSortUp,
    faTrash,
} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import _ from 'lodash';
import {computed, ref, watchEffect} from 'vue';
import VueJsonPretty from 'vue-json-pretty';
import Alert from '@/common/components/Alert.vue';
import Dropdown from '@/common/components/DropDown.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import Pagination from '@/common/components/Pagination.vue';
import {PaginationMeta} from '@/common/parsers/paginatedParser';
import loadingStore from '@/common/stores/loading.store';
const perPageRecordNumber = computed(() => {
    return props.meta?.per_page ?? props.records.length;
});
const modalData = ref();
const modal = ref<HTMLDialogElement | null>(null);
// const pagination = paginationStore();
const loading = loadingStore();

interface recordType {
    name: string,
    real: string
}

interface menuItemType {
    name: string
}

const viewData = (event: object) => {
    // console.log(event);
    modalData.value = event;
    modal.value?.showModal();
};

interface Props {
    language?: string;
    title?: string;
    menuItems?: menuItemType[];
    processColumn: boolean;
    bgColor?: string;
    records: object[];
    columnNames: recordType[];
    exceptColumns?: string[];
    exportFileName?: string;
    crud?: boolean;
    paginate?: boolean;
    meta?: PaginationMeta,
}

const languages = {
    newRecordButtonText: 'Add New',
    filterInputPlaceHolderText: 'Search Record',
    seeAllColumnsText: 'Show All',
    nextButtonText: 'Next',
    previousButtonText: 'Previous',
    alertMessage: 'No Records Here Yet!',
    totalRecord: 'Total Records',
};
const props = withDefaults(defineProps<Props>(), {
    language: 'en',
    title: 'title',
    crud: false,
    paginate: false,
    bgColor: 'bg-gray-300/40',
    menuItems: () => {
        return [];
    },
    exceptColumns: () => {
        return ['id', 'password'];
    },
    exportFileName: 'records',
});
const emit = defineEmits([
    'onCreate', 'onEdit', 'onDelete', 'onRead',
    'onRenew', 'onAddToCart', 'onPay', 'onReprint',
    'onDisapprove', 'onApprove', 'onObjectView',
    'onView', 'updated', 'next', 'refresh', 'page', 'previous', 'perPage',
]);
const cellFormatter = (value: string | object) => {
    return value;
};

// Init comp. needed reactive variable section
const hiddenColumns = ref<string[]>([]);
const sortDirection = ref();
const sortColumnName = ref();
const filterInputValue = ref();
const datatableRecords = ref<object[]>([]);
const pageCount = ref<number>(0);
let allRecords: object[] = [];
// Init comp. needed reactive variable section

// WatchEffect props.records and calculate data
watchEffect(() => {
    // get all records to new array
    allRecords = [...props.records];
    //calculate totalPage count
    pageCount.value = props.meta?.last_page ?? 1;
    // set first page of datatable
    datatableRecords.value = _.chunk(allRecords, perPageRecordNumber.value)[0];
});
// WatchEffect props.records and calculate data

// PreviousPage or next button function
const previousPage = () => {
    emit('previous');
};
const nextPage = () => {
    emit('next');
};
const setPage = (e: string) => {
    emit('page', e);
};
// PreviousPage or next button function

// Show pieces of records method

// Filter records inputbox method
const filterRecords = () => {
    if (!filterInputValue.value) {
        allRecords = props.records;
        pageCount.value = Math.ceil(props.records.length / perPageRecordNumber.value);
        datatableRecords.value = _.chunk(props.records, perPageRecordNumber.value)[0];
    } else {
        allRecords = props.records.filter(item => {
            return JSON.stringify(item).toLocaleLowerCase().indexOf(filterInputValue.value.toLocaleLowerCase()) > -1;
        });
        pageCount.value = Math.ceil(allRecords.length / perPageRecordNumber.value);
        datatableRecords.value = _.chunk(allRecords, perPageRecordNumber.value)[0];
    }
};
// Filter records inputbox method

// Export Excel file section
// const xlsx = inject('xlsx');
// const getExcel = () => {
//     const worksheet = xlsx.utils.json_to_sheet(allRecords);
//     const workbook = xlsx.utils.book_new();
//     xlsx.utils.book_append_sheet(workbook, worksheet, "Records");
//     xlsx.writeFile(workbook, props.exportFileName+'.xlsx');
// }
// Export excel file section

// sortRecords function
const sortRecords = (columnName: string) => {
    sortColumnName.value = columnName;
    if (sortDirection.value === 'asc') {
        sortDirection.value = 'desc';
    } else {
        sortDirection.value = 'asc';
    }
    allRecords = _.orderBy(allRecords, [columnName], [sortDirection.value]);
    datatableRecords.value = _.chunk(allRecords, perPageRecordNumber.value)[0];
};
// sortRecords function

// toggle hiddencolumn function
const toggleHiddenColumn = (columnName: string) => {
    if (hiddenColumns.value.includes(columnName)) {
        hiddenColumns.value.splice(hiddenColumns.value.indexOf(columnName), 1);
    } else {
        hiddenColumns.value.push(columnName);
    }
};
// toggle hiddencolumn function
</script>

<style scoped>
* {
    @apply text-black;
}

.card {
    @apply shadow-xl mb-12 rounded-md z-[1];

    .card-title {
        @apply justify-center underline underline-offset-8;
    }

    .search {
        @apply input input-sm p-2 bg-gray-100 border border-gray-200;
        @apply focus:outline-0 rounded flex-grow lg:flex-grow text-black;
    }

    .header-actions {
        @apply lg:justify-between lg:flex-row flex-col gap-2 items-center hidden lg:flex;
    }

    .showPageSelect {
        @apply px-4 py-2 h-7 justify-center items-center flex;
        @apply rounded bg-gray-200 hover:bg-gray-300 text-gray-500;
    }

    .button {
        @apply btn btn-xs btn-success  hover:bg-gray-600;
        @aply px-4 py-2 focus:outline-0 rounded;
        @apply xl:flex xl:flex-row;
    }

    .action-button {
        @apply flex gap-1;
        @apply justify-around border border-accent;
        @apply items-center px-1 py-0.5 rounded;
    }
}
</style>
