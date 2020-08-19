<template>
    <div>
        <v-app-bar color="deep-purple accent-4" dense dark>
            <v-toolbar-title>Home Page</v-toolbar-title>

            <v-spacer></v-spacer>

            <div class="text-center">
                <v-btn rounded color="primary" dark @click="login">Login</v-btn>
            </div>

            <v-menu left bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item v-for="n in 5" :key="n" @click="() => {}">
                        <v-list-item-title>Option {{ n }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <v-container>
            <v-main>
                This Home Page
            </v-main>
        </v-container>
    </div>
</template>
<script>
export default {
    name: "HomePage",
    methods: {
        login() {
            this.$router.push({
                name: "UserLogin"
            });
        }
    }
};
</script>
