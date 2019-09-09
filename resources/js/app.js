/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import VueRouter from 'vue-router';
import HomeComponent from "./components/HomeComponent";
import CountriesComponent from "./components/CountriesComponent";
import CitiesComponent from "./components/CitiesComponent";
import ContactTypesComponent from "./components/ContactTypesComponent";
import IndustriesComponent from "./components/IndustriesComponent";
import ClientsComponent from "./components/ClientsComponent";
import ClientsCreateComponent from "./components/ClientCreateComponent";
import ClientsEditComponent from "./components/ClientEditComponent";
import Vue from 'vue';

window.Vue = require('vue');
Vue.use(VueRouter);

require('./bootstrap');
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeComponent
        },
        {
            path: '/countries',
            name: 'countries',
            component: CountriesComponent,
        },
        {
            path: '/cities',
            name: 'cities',
            component: CitiesComponent,
        },
        {
            path: '/contact-types',
            name: 'contact-types',
            component: ContactTypesComponent,
        },
        {
            path: '/industries',
            name: 'industries',
            component: IndustriesComponent,
        },
        {
            path: '/clients',
            name: 'clients',
            component: ClientsComponent,
        },
        {
            path: '/clients-create',
            name: 'clients-create',
            component: ClientsCreateComponent,
        },
        {
            path: '/clients-edit/:id',
            name: 'client-edit',
            component: ClientsEditComponent,
        },
    ],
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('home', require('./components/HomeComponent').default);
Vue.component('sidebar', require('./components/SidebarComponent').default);
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
