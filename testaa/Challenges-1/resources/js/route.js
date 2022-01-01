window.Vue = require('vue');
import store from '@/store';
import VueRouter from 'vue-router';

import LayoutLogin from "./pages/admin/Login/LayoutLogin";
import LayoutDashboard from './pages/admin/LayoutDashboard';

import ShowBarcodes from "./pages/admin/barcodes/ShowBarcode";
import AddBarcodes from "./pages/admin/barcodes/AddBarcode";
import EditBarcodes from "./pages/admin/barcodes/EditBarcode";

import ShowProducts from "./pages/admin/products/ShowProduct";
import AddProducts from "./pages/admin/products/AddProduct";
import EditProducts from "./pages/admin/products/EditProduct";

import ShowChallenges from "./pages/admin/challenges/ShowChallenge";
import AddChallenges from "./pages/admin/challenges/AddChallenge";
import EditChallenges from "./pages/admin/challenges/EditChallenge";


import ShowKids from "./pages/admin/kids/ShowKid";
import AddKids from "./pages/admin/kids/AddKid";
import EditKids from "./pages/admin/kids/EditKid";
Vue.use(VueRouter);
Vue.prototype.adminUrl = '/admin/dashboard';
const routes = [{
        path: '/admin/login',
        name: 'admin-login',
        component: LayoutLogin,
        beforeEnter: function(to, from, next) {
            if (store.getters['auth/Authenticated']) {
                next({
                    name: 'barcodes'
                });
            }
            next();
        }
    },
    {
        path: '/admin/dashboard/',
        component: LayoutDashboard,
        name: 'dashboard',
        children: [{
                path: 'barcodes/',
                name: 'barcodes',
                component: ShowBarcodes
            },
            {
                path: 'barcodes/create/',
                name: 'create Barcodes',
                component: AddBarcodes
            },
            {
                path: 'barcodes/edit/:id',
                name: 'edit-barcode',
                component: EditBarcodes
            },
            {
                path: 'products/',
                name: 'products',
                component: ShowProducts
            },
            {
                path: 'products/create/',
                name: 'create Product',
                component: AddProducts
            },
            {
                path: 'products/edit/:id',
                name: 'edit-product',
                component: EditProducts
            },
            {
                path: 'challenges/',
                name: 'challenges',
                component: ShowChallenges
            },
            {
                path: 'challenges/create/',
                name: 'create Challenges',
                component: AddChallenges
            },
            {
                path: 'challenges/edit/:id',
                name: 'edit-challenge',
                component: EditChallenges
            },
            {
                path: 'kids/',
                name: 'kids',
                component: ShowKids,
                meta: {
                    auth: true
                }
            },
            {
                path: 'kids/create/',
                name: 'create Kids',
                component: AddKids
            },
            {
                path: 'kids/edit/:id',
                name: 'edit-kids',
                component: EditKids
            }
        ],
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'admin-login'
                });
            }
            next();
        }
    }
];

const router = new VueRouter({
    mode: 'history',
    routes,
    base: '/',
});



export default router;