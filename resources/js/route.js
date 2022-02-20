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


import AllKids from "./pages/admin/kids/AllKids";
import ShowKid from "./pages/admin/kids/ShowKid";
import ShowSolution from "./pages/admin/solutions/ShowSolution";
import AllSolutions from "./pages/admin/solutions/AllSolutions";

//
// import LayoutUser from "./pages/users/LayoutUser";
import AllChallenges from "./pages/users/challenges/AllChallenges";
import AllProducts from "./pages/users/products/AllProducts";
import LoginUser from "./pages/users/register/LoginPage";
import RegisterUser from "./pages/users/register/RegisterPage";
import SingleChallenge from "./pages/users/challenges/SingleChallenge";
import MyChallenges from "./pages/users/challenges/MyChallenges";
import MySolutionChallenge from "./pages/users/solutions/MySolutionChallenge";
import MyAccount from "./pages/users/account/MyAccount";


// ----------------------------------------------------------------
import ResetPassword from "./pages/users/passwords/ResetPassword";
import ConfirmPassword from "./pages/users/passwords/ConfirmPassword";
import EmailPassword from './pages/users/passwords/EmailPassword';
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
                component: AllKids
            },
            {
                path: 'kids/show/:id',
                name: 'show Kid',
                component: ShowKid
            },
            {
                path: 'solutions/show/:id',
                name: 'showSolution',
                component: ShowSolution
            },
            {
                path: 'solutions/',
                name: 'AllSolutions',
                component: AllSolutions
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
    },
    {
        path: '/login/:barcode?',
        name: 'login',
        component: LoginUser,
        beforeEnter: function(to, from, next) {
            if (store.getters['auth/Authenticated']) {
                next({
                    name: 'products'
                });
            }
            next();
        }
    },
    {
        path: '/register/:barcode',
        name: 'register',
        component: RegisterUser,
        beforeEnter: function(to, from, next) {
            if (store.getters['auth/Authenticated']) {
                next({
                    name: 'products'
                });
            }
            next();
        }
    },
    {
        path: '/password/reset',
        name: 'password-reset',
        component: EmailPassword,
        beforeEnter: function(to, from, next) {
            if (store.getters['auth/Authenticated']) {
                next({
                    name: 'products'
                });
            }
            next();
        }
    },
    {
        path: '/password/reset/:token',
        name: 'password-confirm',
        component: ResetPassword,
        beforeEnter: function(to, from, next) {
            if (store.getters['auth/Authenticated']) {
                next({
                    name: 'products'
                });
            }
            next();
        }
    },
    {
        path: '/products',
        name: 'user-products',
        component: AllProducts,
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'login'
                });
            }
            next();
        }
    },
    {
        path: '/challenges/:product_id',
        name: 'user-challenges',
        component: AllChallenges,
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'login'
                });
            }
            next();
        }
    },
    {
        path: '/challenge/:challenge_id',
        name: 'user-challenge',
        component: SingleChallenge,
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'login'
                });
            }
            next();
        }
    },
    {
        path: '/my-challenges/:kid_id',
        name: 'my-challenges',
        component: MyChallenges,
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'login'
                });
            }
            next();
        }
    },
    {
        path: '/my-solution-challenge/:solution_id',
        name: 'my-solution-challenge',
        component: MySolutionChallenge,
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'login'
                });
            }
            next();
        }
    },
    {
        path: '/my-account',
        name: 'my-account',
        component: MyAccount,
        beforeEnter: function(to, from, next) {
            if (!store.getters['auth/Authenticated']) {
                next({
                    name: 'login'
                });
            }
            next();
        }
    },
];

const router = new VueRouter({
    mode: 'history',
    routes,
    base: '/',
});



export default router;