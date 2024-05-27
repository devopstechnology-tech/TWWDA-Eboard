// const metaStore = useMetaStore(pinia);
import './bootstrap-setup';
import '@@/@vueform/multiselect/themes/default.css';
import '@vuepic/vue-datepicker/dist/main.css';
import Notifications from '@kyvg/vue3-notification';
import {VueQueryPlugin} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {createPinia} from 'pinia';
import {createApp} from 'vue';
import VueApexCharts from 'vue3-apexcharts';
// import useMetaStore from '@/common/stores/meta.store';
import queryClient from '@/queryClient';
import Root from '@/Root.vue';
import router from '@/router';
import Multiselect from '@@/@vueform/multiselect';



const pinia = createPinia();
// import('preline');

const app = createApp(Root)
    .use(pinia)
    .use(Notifications)
    .use(VueApexCharts)
    .use(VueQueryPlugin, {queryClient})
    .use(router);
app.component('Multiselect', Multiselect);
app.component('VueDatePicker', VueDatePicker);
app.mount('#app');
