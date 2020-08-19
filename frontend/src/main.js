import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import vuetify from "./plugins/vuetify";
import axios from "axios";

require("@/store/subscribe");
axios.defaults.baseURL = "http://localhost:8082/api/";
Vue.config.productionTip = false;
let role = localStorage.getItem("role");
if (role == "admin") {
    store.dispatch("auth/attempt", localStorage.getItem("token")).then(() => {
        new Vue({
            router,
            store,
            vuetify,
            render: h => h(App)
        }).$mount("#app");
    });
} else {
    store
        .dispatch("authUser/attempt", localStorage.getItem("token"))
        .then(() => {
            new Vue({
                router,
                store,
                vuetify,
                render: h => h(App)
            }).$mount("#app");
        });
}
