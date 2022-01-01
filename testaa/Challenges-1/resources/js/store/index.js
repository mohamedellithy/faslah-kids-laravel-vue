import Vue from "vue";
import Vuex from 'vuex';
import auth from './auth.js';
import statics from './statics.js';
Vue.use(Vuex);
const store = new Vuex.Store({

    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        statics
    }
});

export default store;