// Importing necessary libraries
// src/types/global.d.ts or similar

import axios from 'axios';
import jQuery from 'jquery';
import Popper from 'popper.js';

declare global {
  interface Window {
    $: typeof jQuery;
    jQuery: typeof jQuery;
    Popper: typeof Popper;
    axios: typeof axios;
  }
}


// Importing Bootstrap JavaScript components
// import 'bootstrap';
// Importing AdminLTE and its OverlayScrollbars plugin
import '../assets/themes/adminlte/plugins/jquery/jquery.min.js';
import '../assets/themes/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import '../assets/themes/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js';
import '../assets/themes/adminlte/dist/js/adminlte.js';
// Axios setup
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios = axios;

// Importing Echo and Pusher if needed, you can uncomment and adjust these based on your actual usage
// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// Note: If you're not using Laravel Echo or Pusher, you can omit the related code.

// yarnadd  "axios": "^1.6.8",, "jquery": "^3.7.1", "popper.js": "^1.16.1",


// Eboard:13-Discussions-Module

// EBboard:13- create discussionMemberRoute, update, delete ,terp
