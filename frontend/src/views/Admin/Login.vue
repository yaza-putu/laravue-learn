<template>
    <v-app id="inspire">
        <v-main>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <template v-if="errors">
                            <v-alert type="error" :value="alert">
                                {{ errors.status }}
                            </v-alert>
                        </template>
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat>
                                <v-toolbar-title>Admin Login</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-form @submit.prevent="submit">
                                <v-card-text>
                                    <v-text-field
                                        label="Login"
                                        name="login"
                                        prepend-icon="mdi-account"
                                        type="text"
                                        v-model="form.username"
                                    ></v-text-field>

                                    <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                        v-model="form.password"
                                    ></v-text-field>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="primary"
                                        type="submit"
                                        id="btn-save"
                                        :disabled="disabled"
                                        >Login</v-btn
                                    >
                                </v-card-actions>
                            </v-form>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
<script>
import { mapActions } from "vuex";
export default {
    name: "Login",
    props: {
        source: String
    },
    data: () => {
        return {
            form: {
                username: "",
                password: ""
            },
            errors: {
                status: ""
            },
            alert: false,
            disabled: false
        };
    },
    methods: {
        ...mapActions({
            login: "auth/login"
        }),
        submit() {
            this.disabled = true;
            document.querySelector("#btn-save").style.cursor = "wait";
            this.login(this.form)
                .then(() => {
                    this.disabled = false;
                    document.querySelector("#btn-save").style.cursor = "auto";
                    this.$router.push({
                        name: "AdminDashboard"
                    });
                })
                .catch(error => {
                    this.errors.status = error.response.data.msg;
                    this.alert = true;
                    this.disabled = false;
                    document.querySelector("#btn-save").style.cursor = "auto";
                    // get all error response
                    // console.log({...error});
                });
        }
    }
};
</script>
