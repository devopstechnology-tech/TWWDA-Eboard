<script setup lang="ts">

import {faAnglesLeft, faAnglesRight} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {ref} from 'vue';
import FormInput from '@/common/components/FormInput.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';

const headers = [
    {name: 'Name', real: 'name'},
    {name: 'Amount', real: 'amount'},
    {name: 'Source', real: 'source'},
    {name: 'Category', real: 'vehicle'},
    {name: 'Location', real: 'location'},
];
const data = [
    {name: 'Permit', amount: '3,200', vehicle: 'SME', location: 'Main Stage', source: 'Web Admin'},
    {name: 'Permit', amount: '30,200', vehicle: 'Hotel', location: 'Area b', source: 'Self Service'},
];
const step = ref(1);
const createSBP = ref(false);
const goToLocation = () => {
    step.value++;
};
const options = [
    {name: 'Zone A', value: '1'},
    {name: 'Zone B', value: '2'},
];
const landType = [
    {name: 'Allotment', value: '1'},
    {name: 'Freehold', value: '2'},
    {name: 'Leasehold', value: '3'},
];
</script>

<template>
    <section class="flex flex-col justify-center mt-12 mx-12 gap-8 ">
        <div class="flex gap-6">
            <button class="btn btn-accent" @click="()=>{createSBP = !createSBP}">
                {{!createSBP ? "Create Land" : "Hide Land FORM"}}
            </button>
            <button class="btn btn-primary">Create Land Bill</button>
        </div>
        <div class="border rounded-md justify-center px-12 py-12 bg-gray-400" v-if="createSBP">
            <h1 class="flex text-xl underline underline-offset-8 justify-center">Create Land</h1>
            <div class="flex  flex-col mt-6">
                <ol class="flex items-center justify-center w-full p-3 space-x-2 text-sm font-medium
                text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm
                dark:text-gray-400 sm:text-base dark:bg-gray-700 dark:border-gray-700 sm:p-4 sm:space-x-4 mb-6">
                    <li class="flex items-center " :class="step>=1?'text-blue-600 dark:text-blue-500':''">
                        <span class="flex items-center
        justify-center w-5 h-5 mr-2 text-xs border border-blue-600
        rounded-full shrink-0 dark:border-blue-500">
                            1
                        </span>
                        Owner <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                        <svg aria-hidden="true" class="w-4 h-4 ml-2 sm:ml-4" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="flex items-center" :class="step>=2?'text-blue-600 dark:text-blue-500':''">
                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border
                        border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            2
                        </span>
                        Land <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                        <svg aria-hidden="true" class="w-4 h-4 ml-2 sm:ml-4" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="flex items-center" :class="step>=3?'text-blue-600 dark:text-blue-500':''">
                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border
                        border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            3
                        </span>
                        Review <span class="hidden sm:inline-flex sm:ml-2">Details</span>
                    </li>
                </ol>

                <form class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6" v-if="step==1">
                    <FormInput name="owner_id" label="Owner ID" placeholder="Enter Owner ID"/>
                    <FormInput name="owner_name" label="Owner Name" placeholder="Owner name" :disabled="true"/>

                    <button type="button" @click="goToLocation"
                            class="btn btn-success mb-1 w-full ml-1 pt-1 text-white mt-10">
                        Next
                        <FontAwesomeIcon :icon="faAnglesRight"/>
                    </button>
                </form>
                <form v-if="step==2">
                    <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                        <FormInput name="plot_number" label="Enter Plot Number" placeholder="Enter Plot Number"/>
                        <FormInput name="size" label="Enter Land Size" placeholder="Enter Land Size in hectares"
                                   type="number"/>
                        <FormSelect name="lease" label="Select Land Type" :options="landType"/>
                        <FormSelect name="sub_county" label="Select SubCounty" :options="options"/>
                        <FormSelect name="ward" label="Select Ward" :options="options"/>
                        <FormInput name="arrears" label="Enter Any arrears" placeholder="Enter Arrears" type="number"/>
                        <FormInput name="fines" label="Enter Any Fines" placeholder="Enter Fines" type="number"/>
                    </div>
                    <div class="flex gap-6 justify-between">
                        <button type="button" @click="()=>{step--}"
                                class="text-white btn btn-error mb-1  ml-1 pt-1 mt-10">
                            <FontAwesomeIcon :icon="faAnglesLeft"/>
                            Go Back
                        </button>
                        <button type="button" @click="()=>{step++}"
                                class="btn btn-success mb-1 ml-1 pt-1 text-white mt-10">
                            Continue
                            <FontAwesomeIcon :icon="faAnglesRight"/>
                        </button>
                    </div>

                </form>
                <form class="" v-if="step==3">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                        <h1>Owner Name: test business</h1>
                        <h1>Owner ID Number: 4444444</h1>
                        <h1>Plot Number: test business</h1>
                        <h1>Land Type: LeaseHold</h1>
                        <h1>Plot Size: 0.008ha</h1>
                        <h1>Sub county: sub</h1>
                        <h1>Ward: ward</h1>
                        <h1>Arrears: 7,800</h1>
                        <h1>Fines: 7,800</h1>
                    </div>
                    <div class="flex gap-6 justify-between">
                        <button type="button" @click="()=>{step--}"
                                class="text-white btn btn-error mb-1 ml-1 pt-1 mt-10">
                            <FontAwesomeIcon :icon="faAnglesLeft"/>
                            Go Back
                        </button>
                        <button type="button" @click="()=>{step++}"
                                class="btn btn-success mb-1 ml-1 pt-1 text-white mt-10">
                            Save
                            <FontAwesomeIcon :icon="faAnglesRight"/>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="mx-12 my-6">
        <SimpleTable title="Land Registry"
                     :records="data"
                     :columnNames="headers"
                     @onEdit="(e)=>{
                         console.log(e)
                     }"
                     export-file-name="payments"
                     :process-column="true"
                     :menu-items="[
                         {
                             name:'View',
                         },
                         {
                             name:'PayAgain',
                         },
                     ]"
        />
        <SimpleTable title="Land Bills"
                     :records="data"
                     :columnNames="headers"
                     @onEdit="(e)=>{
                         console.log(e)
                     }"
                     export-file-name="payments"
                     :process-column="true"
                     :menu-items="[
                         {
                             name:'Approve',
                         },
                     ]"
        />
    </section>
</template>

<style scoped>
.login-button {
    @apply bg-secondary text-white flex items-center justify-center font-bold;
    @apply rounded-md h-12;
    @apply uppercase;
}
</style>
