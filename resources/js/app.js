/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
import VueAxios from 'vue-axios';
import axios from 'axios';

import App from './App.vue';

import CommerceComponent from './components/commerce/CommerceComponent.vue';
import CommerceMore from './components/commerce/CommerceMore.vue';
import AddPositionModal from './components/commerce/AddPositionModal.vue';
import DeletePositionModal from './components/commerce/DeletePositionModal.vue';
import AddCommerceModal from './components/commerce/AddCommerceModal.vue';
import DeleteCommerceModal from './components/commerce/DeleteCommerceModal.vue';
import EditCommerceModal from './components/commerce/EditCommerceModal.vue';
import MakeCommercePdf from './components/commerce/MakeCommercePdf.vue';

import PriceComponent from './components/price/PriceComponent.vue';
import AdminPriceComponent from './components/price/AdminPriceComponent.vue';
import PriceSearchComponent from './components/price/PriceSearchComponent.vue';
import AddPriceModal from './components/price/AddPriceModal.vue';
import EditPriceModal from './components/price/EditPriceModal.vue';
import DeletePriceModal from './components/price/DeletePriceModal.vue';
import RateChart from './components/rate/RateChart.vue';

import BootstrapVue from 'bootstrap-vue'
import Multiselect from 'vue-multiselect'
import VueApexCharts from 'vue-apexcharts'

window.addEventListener('load', function() {
    if (document.getElementById("app")) {
        window.Vue = require('vue');

        Vue.use(VueAxios, axios);
        Vue.use(BootstrapVue)
        Vue.component('apexchart', VueApexCharts)
        Vue.component('rate-chart', RateChart)

        Vue.component('admin-price-table', AdminPriceComponent)
        Vue.component('price-table', PriceComponent)
        Vue.component('price-search', PriceSearchComponent)
        Vue.component('add-price-modal', AddPriceModal)
        Vue.component('edit-price-modal', EditPriceModal)
        Vue.component('delete-price-modal', DeletePriceModal)

        Vue.component('multiselect', Multiselect)
        Vue.component('make-commerce-pdf', MakeCommercePdf)
        Vue.component('edit-commerce-modal', EditCommerceModal)
        Vue.component('delete-commerce-modal', DeleteCommerceModal)
        Vue.component('add-commerce-modal', AddCommerceModal)
        Vue.component('add-position-modal', AddPositionModal)
        Vue.component('delete-position-modal', DeletePositionModal)
        Vue.component('commerce-more', CommerceMore);
        Vue.component('commerce-table', CommerceComponent);
        const app = new Vue(App).$mount('#app');
    }

})

$(document).ready(function() {
    $(document).on('click', '.sidebar-toggle', function(event) {
        event.preventDefault();
        $('.wrapper').toggleClass('wrapper-toggled');
    });
});