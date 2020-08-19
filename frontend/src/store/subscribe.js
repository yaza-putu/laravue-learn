import store from "@/store";
import axios from "axios";

store.subscribe(mutations => {
    switch (mutations.type) {
        case "auth/SET_TOKEN":
            if (mutations.payload) {
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${mutations.payload}`;
                localStorage.setItem("token", mutations.payload);
                localStorage.setItem("role", "admin");
            } else {
                axios.defaults.headers.common["Authorization"] = null;
                localStorage.removeItem("token");
                localStorage.removeItem("role");
            }
            break;
        case "authUser/SET_TOKEN":
            if (mutations.payload) {
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${mutations.payload}`;
                localStorage.setItem("token", mutations.payload);
                localStorage.setItem("role", "user");
            } else {
                axios.defaults.headers.common["Authorization"] = null;
                localStorage.removeItem("token");
                localStorage.removeItem("role");
            }
            break;
    }
});
