import Vue from 'vue'
import Router from 'vue-router'

import App from '../components/app'
import login from '../components/users/login'
import register from '../components/users/register'

import Books from '../components/books/books'
import Book from '../components/books/book'
import editBook from '../components/books/edit'
import createBook from '../components/books/create'
import deleteBook from '../components/books/delete'


Vue.component('app', App);
Vue.component('login', login);
Vue.component('register', register);

Vue.component('books', Books);
Vue.component('book', Book);
Vue.component('editBook', editBook);
Vue.component('createBook', createBook);
Vue.component('deleteBook', deleteBook);

Vue.use(Router);

export default new Router({
    routes: [
        {
            name: 'home',
            path: '/',
        },
        {
            name: 'login',
            path: '/login',
            component: login,
            meta: { checkAuth: true }
        },
        {
            name: 'register',
            path: '/register',
            component: register,
            meta: { checkAuth: true }
        },
        {
            name: 'books',
            path: '/books',
            component: Books,
        },
        {
            name: 'book',
            path: '/book/:bookId',
            component: Book,
        },
        {
            name: 'createBook',
            path: '/book/:bookId/create',
            component: createBook,
            meta: {
                requiresAuth: true,
            }
        },
        {
            name: 'editBook',
            path: '/book/:bookId/edit',
            component: editBook,
            meta: {
                requiresAuth: true,
                checkID: true
            }
        },
        {
            name: 'deleteBook',
            path: '/book/:bookId/delete',
            component: deleteBook,
            meta: {
                requiresAuth: true,
                checkID: true
            }
        },
    ]
})
