import axios from "axios";

export default {
    namespaced: true,
    getters: {
        autenticated(state) {
            return state.token && state.user;
        }
    },
    state: {
        token: null,
        user: null
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_USER(state, data) {
            state.user = data;
        }
    },
    actions: {
        async login({ dispatch }, credentials) {
            let response = await axios.post("user/login", credentials);
            dispatch("attempt", response.data.token);
        },
        async attempt({ commit, state }, token) {
            if (token) {
                commit("SET_TOKEN", token);
            }
            if (!state.token) {
                return false;
            }

            try {
                let response = await axios.get("user/me");
                commit("SET_USER", response.data);
            } catch (error) {
                commit("SET_TOKEN", null);
                commit("SET_USER", null);
            }
        },
        logOut({ commit }) {
            localStorage.removeItem("token") && localStorage.removeItem("role");
            commit("SET_TOKEN", null);
            commit("SET_USER", null);
        }
    }
};
