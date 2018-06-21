
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
Vue.component('assets', require('./components/AssetsComponent.vue'));
Vue.component('blocks', require('./components/BlocksComponent.vue'));
Vue.component('mempool', require('./components/MempoolComponent.vue'));
Vue.component('messages', require('./components/MessagesComponent.vue'));
Vue.component('transactions', require('./components/TransactionsComponent.vue'));
Vue.component('next-prev', require('./components/NextPrevComponent.vue'));
Vue.component('table-tools', require('./components/TableToolsComponent.vue'));
Vue.component('chart', require('./components/ChartComponent.vue'));
Vue.component('chart-area-range', require('./components/ChartAreaRangeComponent.vue'));
Vue.component('chart-market', require('./components/ChartMarketComponent.vue'));
Vue.component('chart-pie', require('./components/ChartPieComponent.vue'));
Vue.component('chart-supply', require('./components/ChartSupplyComponent.vue'));
Vue.component('market-history', require('./components/MarketHistoryComponent.vue'));
Vue.component('list-addresses', require('./components/ListAddressesComponent.vue'));
Vue.component('list-assets', require('./components/ListAssetsComponent.vue'));
Vue.component('balances', require('./components/BalancesComponent.vue'));

Vue.use(require('vue-moment'));

const app = new Vue({
    el: '#app'
});
