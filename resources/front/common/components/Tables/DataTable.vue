<script setup lang="ts">
import {faChevronLeft, faChevronRight, faFilter} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {ref} from 'vue';

const date = ref('');
</script>

<template>
    <section>
        <div class="overflow-x-auto mx-12 my-12">
            <div class="flex justify-between mb-6">
                <h1 class="text-black text-sm">Account Activity Logs</h1>
                <div class="flex gap-4">
                    <VueDatePicker v-model="date" placeholder="Start Date"></VueDatePicker>
                    <VueDatePicker v-model="date" placeholder="End Date"></VueDatePicker>
                    <button class="btn btn-sm bg-secondary text-white">Filter
                        <FontAwesomeIcon :icon="faFilter"/>
                    </button>
                </div>
                <div class="form-control">
                    <input class="input input-bordered input-xs w-full max-w-xs" placeholder="Search" type="text"/>
                </div>
            </div>
            <table class="table table-sm text-black font-medium">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>company</th>
                        <th>location</th>
                        <th>Last Login</th>
                        <th>Favorite Color</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <td>Cy Ganderton</td>
                        <td>Quality Control Specialist</td>
                        <td>Littel, Schaden and Vandervort</td>
                        <td>Canada</td>
                        <td>12/16/2020</td>
                        <td>Blue</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Hart Hagerty</td>
                        <td>Desktop Support Technician</td>
                        <td>Zemlak, Daniel and Leannon</td>
                        <td>United States</td>
                        <td>12/5/2020</td>
                        <td>Purple</td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>Brice Swyre</td>
                        <td>Tax Accountant</td>
                        <td>Carroll Group</td>
                        <td>China</td>
                        <td>8/15/2020</td>
                        <td>Red</td>
                    </tr>
                    <tr>
                        <th>4</th>
                        <td>Marjy Ferencz</td>
                        <td>Office Assistant I</td>
                        <td>Rowe-Schoen</td>
                        <td>Russia</td>
                        <td>3/25/2021</td>
                        <td>Crimson</td>
                    </tr>
                    <tr>
                        <th>5</th>
                        <td>Yancy Tear</td>
                        <td>Community Outreach Specialist</td>
                        <td>Wyman-Ledner</td>
                        <td>Brazil</td>
                        <td>5/22/2020</td>
                        <td>Indigo</td>
                    </tr>
                    <tr>
                        <th>6</th>
                        <td>Irma Vasilik</td>
                        <td>Editor</td>
                        <td>Wiza, Bins and Emard</td>
                        <td>Venezuela</td>
                        <td>12/8/2020</td>
                        <td>Purple</td>
                    </tr>
                    <tr>
                        <th>7</th>
                        <td>Meghann Durtnal</td>
                        <td>Staff Accountant IV</td>
                        <td>Schuster-Schimmel</td>
                        <td>Philippines</td>
                        <td>2/17/2021</td>
                        <td>Yellow</td>
                    </tr>
                    <tr>
                        <th>8</th>
                        <td>Sammy Seston</td>
                        <td>Accountant I</td>
                        <td>O'Hara, Welch and Keebler</td>
                        <td>Indonesia</td>
                        <td>5/23/2020</td>
                        <td>Crimson</td>
                    </tr>
                    <tr>
                        <th>9</th>
                        <td>Lesya Tinham</td>
                        <td>Safety Technician IV</td>
                        <td>Turner-Kuhlman</td>
                        <td>Philippines</td>
                        <td>2/21/2021</td>
                        <td>Maroon</td>
                    </tr>
                    <tr>
                        <th>10</th>
                        <td>Zaneta Tewkesbury</td>
                        <td>VP Marketing</td>
                        <td>Sauer LLC</td>
                        <td>Chad</td>
                        <td>6/23/2020</td>
                        <td>Green</td>
                    </tr>
                    <tr>
                        <th>11</th>
                        <td>Andy Tipple</td>
                        <td>Librarian</td>
                        <td>Hilpert Group</td>
                        <td>Poland</td>
                        <td>7/9/2020</td>
                        <td>Indigo</td>
                    </tr>
                    <tr>
                        <th>12</th>
                        <td>Sophi Biles</td>
                        <td>Recruiting Manager</td>
                        <td>Gutmann Inc</td>
                        <td>Indonesia</td>
                        <td>2/12/2021</td>
                        <td>Maroon</td>
                    </tr>
                    <tr>
                        <th>13</th>
                        <td>Florida Garces</td>
                        <td>Web Developer IV</td>
                        <td>Gaylord, Pacocha and Baumbach</td>
                        <td>Poland</td>
                        <td>5/31/2020</td>
                        <td>Purple</td>
                    </tr>
                    <tr>
                        <th>14</th>
                        <td>Maribeth Popping</td>
                        <td>Analyst Programmer</td>
                        <td>Deckow-Pouros</td>
                        <td>Portugal</td>
                        <td>4/27/2021</td>
                        <td>Aquamarine</td>
                    </tr>
                    <tr>
                        <th>15</th>
                        <td>Moritz Dryburgh</td>
                        <td>Dental Hygienist</td>
                        <td>Schiller, Cole and Hackett</td>
                        <td>Sri Lanka</td>
                        <td>8/8/2020</td>
                        <td>Crimson</td>
                    </tr>
                    <tr>
                        <th>16</th>
                        <td>Reid Semiras</td>
                        <td>Teacher</td>
                        <td>Sporer, Sipes and Rogahn</td>
                        <td>Poland</td>
                        <td>7/30/2020</td>
                        <td>Green</td>
                    </tr>
                    <tr>
                        <th>17</th>
                        <td>Alec Lethby</td>
                        <td>Teacher</td>
                        <td>Reichel, Glover and Hamill</td>
                        <td>China</td>
                        <td>2/28/2021</td>
                        <td>Khaki</td>
                    </tr>
                    <tr>
                        <th>18</th>
                        <td>Aland Wilber</td>
                        <td>Quality Control Specialist</td>
                        <td>Kshlerin, Rogahn and Swaniawski</td>
                        <td>Czech Republic</td>
                        <td>9/29/2020</td>
                        <td>Purple</td>
                    </tr>
                    <tr>
                        <th>19</th>
                        <td>Teddie Duerden</td>
                        <td>Staff Accountant III</td>
                        <td>Pouros, Ullrich and Windler</td>
                        <td>France</td>
                        <td>10/27/2020</td>
                        <td>Aquamarine</td>
                    </tr>
                    <tr>
                        <th>20</th>
                        <td>Lorelei Blackstone</td>
                        <td>Data Coordiator</td>
                        <td>Witting, Kutch and Greenfelder</td>
                        <td>Kazakhstan</td>
                        <td>6/3/2020</td>
                        <td>Red</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 justify-between sm:hidden">
                    <a class="relative inline-flex
                    items-center rounded-md border border-gray-300
                    bg-white px-4 py-2 text-sm font-medium text-gray-700
                    hover:bg-gray-50"
                       href="#">Previous</a>
                    <a class="relative ml-3 inline-flex items-center
                     rounded-md border border-gray-300 bg-white px-4 py-2
                     text-sm font-medium text-gray-700 hover:bg-gray-50"
                       href="#">Next</a>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">1</span>
                            to
                            <span class="font-medium">20</span>
                            of
                            <span class="font-medium">97</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                            <a class="relative inline-flex items-center rounded-l-md
                            px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300
                            hover:bg-gray-50 focus:z-1 focus:outline-offset-0"
                               href="#">
                                <span class="sr-only">Previous</span>
                                <FontAwesomeIcon :icon="faChevronLeft"/>
                            </a>
                            <a aria-current="page"
                               class="relative z-1 inline-flex items-center
                               bg-indigo-600 px-4 py-2 text-sm font-semibold
                               text-white focus:z-2 focus-visible:outline
                               focus-visible:outline-2 focus-visible:outline-offset-2
                                focus-visible:outline-indigo-600"
                               href="#">1</a>
                            <a class="relative inline-flex items-center px-4 py-2
                            text-sm font-semibold text-gray-900 ring-1 ring-inset
                            ring-gray-300 hover:bg-gray-50 focus:z-2 focus:outline-offset-0"
                               href="#">2</a>
                            <a class="relative hidden items-center px-4 py-2 text-sm
                            font-semibold text-gray-900 ring-1 ring-inset ring-gray-300
                            hover:bg-gray-50 focus:z-2 focus:outline-offset-0 md:inline-flex"
                               href="#">3</a>
                            <span
                                class="relative inline-flex items-center px-4 py-2
                                text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300
                                focus:outline-offset-0">...</span>
                            <a class="relative hidden items-center px-4 py-2 text-sm
                            font-semibold text-gray-900 ring-1 ring-inset ring-gray-300
                            hover:bg-gray-50 focus:z-2 focus:outline-offset-0 md:inline-flex"
                               href="#">8</a>
                            <a class="relative inline-flex items-center px-4 py-2 text-sm
                            font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50
                            focus:z-2 focus:outline-offset-0"
                               href="#">9</a>
                            <a class="relative inline-flex items-center px-4 py-2 text-sm
                            font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50
                            focus:z-2 focus:outline-offset-0"
                               href="#">10</a>
                            <a class="relative inline-flex items-center rounded-r-md px-2 py-2
                            text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-2
                            focus:outline-offset-0"
                               href="#">
                                <span class="sr-only">Next</span>
                                <FontAwesomeIcon :icon="faChevronRight"/>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
