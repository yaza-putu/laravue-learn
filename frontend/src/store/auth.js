import axios from "axios";
export default {
    namespaced: true,
    getters: {
        autenticated(state) {
            return state.token && state.admins;
        },
        admins(state) {
            return state.admins;
        }
    },
    state: {
        token: null,
        admins: null
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_ADMIN(state, data) {
            state.admins = data;
        }
    },
    actions: {
        async login({ dispatch }, credintials) {
            let response = await axios.post("admin/login", credintials);
            return dispatch("attempt", response.data.token);
        },
        async attempt({ commit, state }, token) {
            if (token) {
                commit("SET_TOKEN", token);
            }
            if (!state.token) {
                return false;
            }
            try {
                let response = await axios.get("admin/me");
                if (response.data.error) {
                    commit("SET_TOKEN", null);
                } else {
                    commit("SET_ADMIN", response.data);
                }
            } catch (error) {
                commit("SET_TOKEN", null);
                commit("SET_ADMIN", null);
            }
        },
        logOut({ commit }) {
            return axios.post("admin/logout").then(() => {
                localStorage.removeItem("token");
                commit("SET_TOKEN", null);
                commit("SET_ADMIN", null);
            });
        }
    }
};
