
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('search', require('./components/SearchComponent.vue'));
Vue.component('statistics', require('./components/StatisticsComponent.vue'));
Vue.component('addresses', require('./components/AddressesComponent.vue'));
Vue.component('assets', require('./components/AssetsComponent.vue'));
Vue.component('blocks', require('./components/BlocksComponent.vue'));
Vue.component('messages', require('./components/MessagesComponent.vue'));
Vue.component('transactions', require('./components/TransactionsComponent.vue'));
Vue.component('next-prev', require('./components/NextPrevComponent.vue'));
Vue.component('table-tools', require('./components/TableToolsComponent.vue'));
Vue.component('chart-assets', require('./components/ChartAssetsComponent.vue'));
Vue.component('chart-transactions', require('./components/ChartTransactionsComponent.vue'));

const app = new Vue({
    el: '#app'
});
