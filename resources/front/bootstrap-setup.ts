/* eslint-disable simple-import-sort/imports */
import axios from 'axios';
import jQuery from 'jquery';
import Popper from 'popper.js';
import '../assets/themes/adminlte/plugins/jquery/jquery.min.js';
import '../assets/themes/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import '../assets/themes/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js';
import '../assets/themes/adminlte/dist/js/adminlte.js';

declare global {
  interface Window {
    $: typeof jQuery;
    jQuery: typeof jQuery;
    Popper: typeof Popper;
    axios: typeof axios;
  }
}

window.$ = window.jQuery = jQuery;
window.Popper = Popper;
window.axios = axios;

// Initialize tooltips
// $(function() {
//     $('[data-toggle="tooltip"]').tooltip();
// });
