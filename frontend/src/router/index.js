import Vue from "vue";
import VueRouter from "vue-router";
import HomePage from "../views/HomePage.vue";
import store from "@/store";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Home",
        component: HomePage
    },
    {
        path: "/user",
        name: "UserDashboard",
        component: () =>
            import(/* webpackChunkName: "user" */ "@/views/User/Dashboard.vue"),
        beforeEnter: (to, from, next) => {
            if (!store.getters["authUser/autenticated"]) {
                return next({
                    name: "UserLogin"
                });
            } else {
                next();
            }
        }
    },
    {
        path: "/admin",
        name: "AdminDashboard",
        component: () =>
            import(
                /* webpackChunkName: "user" */ "@/views/Admin/Dashboard.vue"
            ),
        beforeEnter: (to, from, next) => {
            if (!store.getters["auth/autenticated"]) {
                return next({
                    name: "AdminLogin"
                });
            } else {
                next();
            }
        }
    },
    {
        path: "/user/login",
        name: "UserLogin",
        component: () =>
            import(/* webpackChunkName: "userLogin" */ "@/views/User/Login.vue")
    },
    {
        path: "/admin/login",
        name: "AdminLogin",
        component: () =>
            import(
                /* webpackChunkName: "adminLogin" */ "@/views/Admin/Login.vue"
            )
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
