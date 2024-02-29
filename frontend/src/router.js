import {createRouter, createWebHistory} from 'vue-router';
import CarrierList from '@/components/admin/carrier/CarrierList.vue';
import DeliveryCost from '@/components/main/carrier/DeliveryCost.vue';
import HomeLinks from "@/components/main/home/HomeLinks.vue";
import TextManagement from "@/components/main/text/TextManagement.vue";

const redirectToHome = (to, from, next) => next({path: "/"})

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeLinks,
        meta: {title: 'Home', transition: 'fade'},
    },
    {
        path: '/delivery-cost',
        name: 'DeliveryCost',
        component: DeliveryCost,
        meta: {title: 'Delivery Cost Calculator', transition: 'fade'},
    },
    {
        path: '/text-management',
        name: 'TextManagement',
        component: TextManagement,
        meta: {title: 'Text Parser', transition: 'fade'},
    },
    {
        path: '/admin',
        name: 'Dashboard',
        component: CarrierList,
        meta: {title: 'Dashboard', transition: 'fade'},
    },
    {
        path: '/admin/carriers',
        name: 'CarrierList',
        component: CarrierList,
        meta: {title: 'Carriers', transition: 'fade'},
    },
    {
        name: 'Not Found',
        path: '/:pathMatch(.*)*',
        //TODO 404 page
        beforeEnter: redirectToHome
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
