<script setup lang="ts">
import 'vue-json-pretty/lib/styles.css';
import {
    faBook,
    faCheck,
    faClose,
    faMoneyBill,
    faPencil,
    faPrint,
    faShoppingBasket,
    faSortDown,
    faSortUp,
    faTrash,
} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import _ from 'lodash';
import {ref, watchEffect} from 'vue';
import VueJsonPretty from 'vue-json-pretty';


const modalData = ref({});
const modal = ref<HTMLDialogElement | null>(null);

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
}

const props = withDefaults(defineProps<Props>(), {
    language: 'en',
    title: 'title',
    crud: false,
    bgColor: 'bg-gray-700',
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
]);
const cellFormatter = (value: string | object, key: number) => {
    if (key === 100) {
        return 'test';
    }

    return value;
};

// Init comp. needed reactive variable section
const perPageRecordNumber = ref(10);
const hiddenColumns = ref<string[]>([]);
const sortDirection = ref();
const sortColumnName = ref();
const datatableRecords = ref<object[]>([]);
let allRecords: object[] = [];
// Init comp. needed reactive variable section

// WatchEffect props.records and calculate data
watchEffect(() => {
    // get all records to new array
    allRecords = [...props.records];
    // set first page of datatable
    datatableRecords.value = _.chunk(allRecords, perPageRecordNumber.value)[0];
});
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
</script>

<template>
    <div class="rounded overflow-auto border mb-2 bg-gray-100">
        <table class="table-xs table-auto w-full text-center text-black border border-primary rounded">
            <thead class="bg-gray-300 text-gray-700">
                <tr>
                    <th class="p-2" :class="{'hidden':hiddenColumns.includes(columnName.real)}"
                        v-for="columnName in columnNames" :key="columnName.name">
                        <div class="flex gap-2 items-center justify-center">
                            <span @click="sortRecords(columnName.real)"
                                  class="hover:text-gray-700 cursor-pointer">
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
                    <th v-if="menuItems?.length>0">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-600 text-black">
                <tr v-for="(record, index) in datatableRecords" :class="{'bg-gray-500':index % 2 !== 0}"
                    :key="index">
                    <td :class="{'hidden':hiddenColumns.includes(key)}" class="p-2 min-w-fit"
                        v-for="(key,i) in Object.keys(record)"
                        v-show="!exceptColumns!.includes(key)" :key="key">
                        <span v-if="typeof record[key as keyof typeof record]!=='object'">
                            {{cellFormatter(record[key as keyof typeof record], i)}}
                        </span>

                        <button class="btn btn-accent btn-xs" v-else
                                @click.prevent="viewData(record)">
                            View Data
                        </button>

                    </td>
                    <td class="" v-if="menuItems?.length>0">
                        <span class="flex gap-2 justify-center items-center">
                            <span v-if="menuItems?.some(e=>e.name==='Edit')">
                                <button class="btn btn-xs btn-secondary"
                                        @click.prevent="emit('onEdit', record)">
                                    Edit
                                    <FontAwesomeIcon
                                        :icon="faPencil"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Delete')">
                                <button class="btn btn-xs btn-accent"
                                        @click.prevent="emit('onDelete', record)">
                                    Delete
                                    <FontAwesomeIcon
                                        :icon="faTrash"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='PayAgain')">
                                <button class="btn btn-xs btn-accent"
                                        @click.prevent="emit('onRenew', record)">
                                    Renew
                                    <FontAwesomeIcon
                                        :icon="faMoneyBill"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Pay')">
                                <button class="btn btn-xs btn-accent"
                                        @click.prevent="emit('onPay', record)">
                                    Pay
                                    <FontAwesomeIcon
                                        :icon="faMoneyBill"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Cart')">
                                <button class="btn btn-xs btn-primary"
                                        @click.prevent="emit('onAddToCart', record)">
                                    Add to Cart
                                    <FontAwesomeIcon
                                        :icon="faShoppingBasket"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Reprint')">
                                <button class="btn btn-xs btn-primary"
                                        @click.prevent="emit('onReprint', record)">
                                    Print
                                    <FontAwesomeIcon
                                        :icon="faPrint"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Approve')">
                                <button class="btn btn-xs btn-success text-black"
                                        @click.prevent="emit('onApprove', record)">
                                    Approve
                                    <FontAwesomeIcon
                                        :icon="faCheck"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Disapprove')">
                                <button class="btn btn-xs btn-error text-black"
                                        @click.prevent="emit('onDisapprove', record)">
                                    Disapprove
                                    <FontAwesomeIcon
                                        :icon="faClose"/>
                                </button>
                            </span>
                            <span v-if="menuItems?.some(e=>e.name==='Read')">
                                <button class="btn btn-xs btn-accent text-black"
                                        @click.prevent="emit('onDisapprove', record)">
                                    Mark as Read
                                    <FontAwesomeIcon
                                        :icon="faBook"/>
                                </button>
                            </span>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <dialog id="my_modal_1" class="modal" ref="modal">
            <form method="dialog" class="modal-box">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <h3 class="font-bold text-lg">Data</h3>
                <vue-json-pretty :data="modalData"/>
            </form>
        </dialog>
    </div>
</template>

<style scoped>

</style>
