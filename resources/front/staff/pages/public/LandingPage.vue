<template>
    <section class="bg-gray-200">
        <div class="lg:flex flex-col lg:flex-row lg:justify-between lg:items-center hidden
         justify-center items-center lg:mx-40 mx-24 my-2">
            <h1 class="font-semibold  lg:text-2xl text-xl mt-3">
                Available on the <br class="block lg:hidden">platforms you love most</h1>
            <div class="lg:mr-2 mt-3">
                <a href="">
                    <img :src="googlePlay" class="lg:h-12" alt="">
                </a>
            </div>
            <div class="mt-3">
                <a href="">
                    <img :src="playStore" class="lg:h-12" alt="">
                </a>
            </div>
        </div>
    </section>
    <section class="bg-gradient-to-r from-blue-veryDark  to-blue-dark mt-6 mb-6">
        <div class="grid grid-cols-1">
            <div class="lg:pl-12 text-white">
                <div class="flex  flex-col justify-center items-center  ">
                    <h2 class="font-semibold  lg:text-6xl text-4xl mt-12 w-11/12 text-center
                                text-white tracking-wide">Pay for County Services with Ease</h2>
                    <p class="mt-2  font-thin lg:text-lg sm:block leading-loose w-11/12 text-center">
                        Ease your mind with these simple payment options
                    </p>
                </div>
            </div>
        </div>
        <div class="lg:mx-12 mx-12 flex flex-col gap-1 mt-1 justify-between items-center my-12">
            <FancyBorder v-for="faq in faqs"
                         :key="faq.question"
                         direction="up"
                         start-color="from-white"
                         mid-color="via-black"
                         end-color="to-white"
                         class="mx-auto mt-3">
                <Disclosure v-slot="{ open }" default-open>
                    <DisclosureButton class=" text-white p-3 flex w-full justify-between items-center
                         bg-gradient-to-r from-blue-veryDark to-blue-dark px-4 py-4
                         text-left text-xl font-semibold  hover:bg-alt focus:outline-none
                         focus-visible:ring focus-visible:ring-secondary focus-visible:ring-opacity-75"
                    >
                        <span>{{faq.question}}</span>
                        <PlusIcon v-if="!open"
                                  class="h-5 w-5 text-accent"
                        />
                        <MinusIcon v-else
                                   :class="open ? 'text-red-600' : ''"
                                   class="h-5 w-5 text-accent"
                        />
                    </DisclosureButton>
                    <DisclosurePanel class="px-4 pt-4 pb-2 text-xl text-white bg-gradient-to-tr
                        from-blue-veryDark to-accent">
                        <span v-html="faq.answer"/>
                    </DisclosurePanel>
                </Disclosure>
            </FancyBorder>
            <div class="mb-12"></div>
        </div>
    </section>
    <section class="bg-white">
        <div class="flex flex-col justify-center items-center">
            <h1 class="font-semibold text-5xl my-6 w-11/12 text-center
                                tracking-wide">Services Available</h1>
        </div>
    </section>
    <section class="flex flex-col w-full px-12">
        <div class="grid grid-cols-1 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-6 py-6">
            <div v-for="(payment,i) in payments"
                 :key="i"
                 class="flex flex-row justify-around px-4 py-4 bg-white
                bg-gradient-to-r from-blue-700 via-blue-800
                to-blue-900 p-8 rounded-lg border-2 border-blue-500 hover:cursor-pointer"
                 @click="()=>{}"
            >
                <div class="my-auto">
                    <div class="text-lg text-blue-300">{{payment.name}}</div>
                    <!--                    <div class="text-4xl text-blue-100">622k</div>-->
                </div>
                <div class="text-blue-300 my-auto bg-gradient-to-l
                    from-blue-700 via-blue-800 to-blue-900 rounded-full p-1">
                    <FontAwesomeIcon :icon="payment.icon" class="fa-2xl"/>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white">
        <div class="flex flex-col justify-center items-center">
            <h1 class="font-semibold text-5xl my-6 w-11/12 text-center
                                tracking-wide">Start your journey today</h1>
        </div>
    </section>
    <section class="bg-gradient-to-r from-blue-veryDark  to-blue-dark flex flex-col w-full">
        <div class="bg-gradient-to- from-blue-veryDark  to-blue-dark mx-12">
            <div class="font-thin text-sm flex flex-col justify-center lg:gap-6 lg:items-center mb-5">
                <div class="grid grid-cols-2  lg:grid-cols-4 gap-6 my-12">
                    <div class="card w-full outline text-white">
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">USSD</h2>
                            <p class="text-2xl">Dial * 544 # on your phone and pay for services</p>
                        </div>
                    </div>
                    <div class="card w-full outline text-white">
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">Citizen Login</h2>
                            <p class="text-2xl">Use our web platform and pay for services</p>
                            <div class="card-actions justify-end mt-6">
                                <router-link to="/login" class="btn btn-secondary btn-sm btn-block">Login</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card w-full outline text-white">
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">Staff Login</h2>
                            <p class="text-2xl">Admistrative Collectors dashboard</p>
                            <div class="card-actions justify-end mt-6">
                                <router-link to="/staff/login" class="btn btn-secondary btn-sm btn-block">Login
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card w-full outline text-white">
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">Agent Payment</h2>
                            <p class="text-2xl">Find any of our collection agents and pay via terminal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup lang="ts">
import playStore from '@assets/images/appstore.svg';
import googlePlay from '@assets/images/google-play.svg';
import {
    faBusinessTime,
    faCab,
    faCaravan,
    faCow,
    faHeart,
    faHouseChimneyCrack,
    faLandmark,
    faMapLocation,
    faMoneyBill1,
    faTractor,
} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue';
import {MinusIcon, PlusIcon} from '@heroicons/vue/20/solid';
import FancyBorder from '@/common/components/FancyBorder.vue';


const faqs = [
    {
        question: 'What services can I pay for?',
        answer:
            'You can pay for all county services such as parking, houses, stalls, business permits, markets, cess etc',
    },
    {
        question: 'What Payment options are available to me?',
        answer:
            'You can pay via any of these ways<br/>' +
            '1. Use USSD and dial <b>*555#</b> on your phone. <br/>' +
            '2. Pay via web portal <br/>' +
            '3. Visit County Offices and Pay <br/>' +
            '4. Make Payment via County Official terminal',
    },
];
const payments = [
    {name: 'Pay for Parking', to: 'to', icon: faCab},
    {name: 'Pay for SBP', to: 'to', icon: faBusinessTime},
    {name: 'Pay for Cess', to: 'to', icon: faTractor},
    {name: 'Pay for Market', to: 'to', icon: faMapLocation},
    {name: 'Pay for Land Services', to: 'to', icon: faLandmark},
    {name: 'Pay for Stalls', to: 'to', icon: faCaravan},
    {name: 'Pay for Bills', to: 'to', icon: faMoneyBill1},
    {name: 'Pay for Physical Planning', to: 'to', icon: faHouseChimneyCrack},
    {name: 'Pay for Health Services', to: 'to', icon: faHeart},
    {name: 'Pay for Veterinary Services', to: 'to', icon: faCow},
];
</script>
<style scoped>

.login-button {
    @apply bg-secondary text-white flex justify-center items-center font-bold;
    @apply rounded-md h-12 px-2 ;
    @apply uppercase;
}

.features {
    span:before {
        content: '';
        animation: wordChange infinite 8s;
        color: orangered;
    }

    @keyframes wordChange {
        0% {
            content: 'Pay';
            color: darkblue;
        }
        50% {
            content: 'Verify';
            color: green;
        }
        100% {
            content: 'SafeGuard';
            color: red;
        }
    }
}

</style>
