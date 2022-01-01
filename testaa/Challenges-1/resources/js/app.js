/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import router from './route';
import DashboardPlugin from './plugins/dashboard-plugin';
import TextEditor from './texteditor.js';
import VueHtmlToPaper from './VueHtmlToPaper.js';
import VueProgressBar from 'vue-progressbar';
import axios from 'axios';
import store from '@/store';
import Vue from 'vue';
window.Vue = require('vue');


// import auth from './auth';
require('@/store/subscriber');


window.Event = new Vue();


Vue.use(DashboardPlugin);
Vue.use(VueHtmlToPaper);

Vue.use(axios);
Vue.use(VueProgressBar, {
        color: 'green',
        failedColor: 'red',
        height: '20px',
        width: '20px',
        thickness: '5px'
    })
    /**
     * The following block of code may be used to automatically register your
     * Vue components. It will recursively scan this directory for the Vue
     * components and automatically register them with their "basename".
     *
     * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
     */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


axios.defaults.baseURL = 'http://sara.challenges';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
store.dispatch('auth/attempt', window.localStorage.getItem('token')).then(() => {
    const app = new Vue({
        el: '#app',
        data: { userCheck: false },
        store,
        router
    });
});

router.beforeEach((to, from, next) => {
    console.log(to.name);
    store.dispatch('statics/GetStatics', { params: { section: to.name } });
    next();
});
// create a root instance
