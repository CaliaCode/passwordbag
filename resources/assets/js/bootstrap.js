// jQuery
window.$ = window.jQuery = require('jquery');

// Bootstrap
require('bootstrap-sass');

// DataTables
require('datatables.net-bs')(window, $);

// Notification Plugin
require('noty');

// Improved Select input
require('select2');

// Clipboard
require('clipboard');

// Vue, Vue Resource
window.Vue = require('vue');
const VueResource = require('vue-resource');

// Attach Vue resource to Vue
Vue.use(VueResource);

// Set BaseUrl for VueResource HTTP Requests
Vue.http.options.root = window.baseUrl;

// Attach to each request the header "X-CSRF-TOKEN"
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});


