/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
import Vuetify from 'vuetify';
import axios from 'axios';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import * as Cookies from 'js-cookie';
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'


window.Vue = require('vue');
window.axios = axios;
window.Swal = Swal;

Vue.use(Vuex);
Vue.use(Vuetify);

import router from './routes/router'

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept':'application/json',
    'Content-type':'application/json'
};
const store = new Vuex.Store({
    plugins: [
        createPersistedState({
            storage: {
                getItem: key => Cookies.get(key),
                setItem: (key, value) =>
                    Cookies.set(key, value, { expires: 3, secure: true }),
                removeItem: key => Cookies.remove(key),
            },
        }),
    ],
    state: {
        user: Cookies.get('user')
            ? JSON.parse(Cookies.get('user'))
            : null,
    },
    mutations: {
        setData(state, user){
            Cookies.set('user', user);
            state.user = user;
        },
        removeData(state){
            Cookies.remove('user');
            state.user = null;
        }
    },
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) && !store.state.user) {
        next({ name: 'login'});
    }
    if(to.matched.some(record => record.meta.checkAuth) && store.state.user){
        next({ name: 'home'});
    }
    if(to.matched.some(record => record.meta.checkID) && store.state.user){
        if( store.state.user.role !== 'admin' && to.params.bookId){
            axios.get('/api/books/'+to.params.bookId)
                .then(response => {
                    if(!(response.data.book.user) || (response.data.book.user.id !== store.state.user.id)){
                        console.log(response.data.book.user && response.data.book.user.id !== store.state.user.id);
                        router.go(-1);
                    }
                })
        }
    }
    next();
});
const app = new Vue({
    el: '#app',
    store,
    router,
}).$mount('#app');
