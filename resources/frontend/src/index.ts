// @ts-ignore
import {createApp} from "vue/dist/vue.esm-bundler";
import {createPinia} from "pinia";
import {createRouter, createWebHistory} from "vue-router";

import './scss/app.scss';

import Home from "./js/components/Pages/Home/Home.vue";
import ListOperation from "./js/components/Pages/ListOperation/ListOperation.vue";
import PageNotFound from "./js/components/Pages/PageNotFound/PageNotFound.vue";

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/operations',
        component: ListOperation
    },
    {
        path: "/:catchAll(.*)",
        component: PageNotFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


const app = createApp({});

app.use(createPinia());
app.use(router);

app.mount('#app');