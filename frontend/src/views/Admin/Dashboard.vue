<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list dense>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <router-link :to="{ name: 'AdminDashboard' }">
                            <v-list-item-title>Home</v-list-item-title>
                        </router-link>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-account-cog-outline</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <router-link :to="{ name: 'AdminUser' }">
                            <v-list-item-title>Users</v-list-item-title>
                        </router-link>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title
                            ><button @click="signOut">
                                Logout
                            </button></v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="indigo" dark>
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>Admin</v-toolbar-title>
        </v-app-bar>
        <v-main>       
            <template v-if="isHome">  
                <v-container>
                i'm Home
                </v-container>
            </template>     
            <router-view name="adminView"></router-view>
        </v-main>
        <v-footer color="indigo" app>
            <span class="white--text"
                >&copy; {{ new Date().getFullYear() }}</span
            >
        </v-footer>
    </v-app>
</template>

<script>
import { mapActions } from "vuex";
export default {
    props: {
        source: String
    },
    data: () => ({
        drawer: null,
        home:false,
    }),
    methods: {
        ...mapActions({
            logOut: "auth/logOut"
        }),
        signOut() {
            this.logOut().then(() => {
                this.$router.push({
                    name: "AdminLogin"
                });
            });
        }
    },
    computed:{
        isHome:function(){
            if(this.$route.name == "AdminDashboard")
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
};
</script>
<style>
.v-list-item__title {
    color: black;
}
a {
    text-decoration: none;
}
.v-list-item__title:active {
    color: red !important;
}
</style>
