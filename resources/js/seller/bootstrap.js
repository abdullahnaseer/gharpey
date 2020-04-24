window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    // Keentheme"s plugins
    window.KTUtil = require("../metronic/global/components/base/util");
    window.KTApp = require("../metronic/global/components/base/app");
    window.KTAvatar = require("../metronic/global/components/base/avatar");
    window.KTDialog = require("../metronic/global/components/base/dialog");
    window.KTHeader = require("../metronic/global/components/base/header");
    window.KTMenu = require("../metronic/global/components/base/menu");
    window.KTOffcanvas = require("../metronic/global/components/base/offcanvas");
    window.KTPortlet = require("../metronic/global/components/base/portlet");
    window.KTScrolltop = require("../metronic/global/components/base/scrolltop");
    window.KTToggle = require("../metronic/global/components/base/toggle");
    window.KTWizard = require("../metronic/global/components/base/wizard");
    require("../metronic/global/components/base/datatable/core.datatable");
    require("../metronic/global/components/base/datatable/datatable.checkbox");
    require("../metronic/global/components/base/datatable/datatable.rtl");

    // Layout scripts
    window.KTLayout = require("../metronic/global/layout/layout");
    window.KTChat = require("../metronic/global/layout/chat");
    require("../metronic/global/layout/demo-panel");
    require("../metronic/global/layout/offcanvas-panel");
    require("../metronic/global/layout/quick-panel");
    require("../metronic/global/layout/quick-search");

    // Custom Code
    //..
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
