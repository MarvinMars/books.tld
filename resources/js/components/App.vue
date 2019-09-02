<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            fixed
            app
        >
            <v-list dense>
                <v-list-tile  :to="{ name: 'home' }">
                    <v-list-tile-action>
                        <v-icon>home</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Home</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: 'books' }" >
                    <v-list-tile-action>
                        <v-icon>book</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Books</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar color="indigo" app>
            <v-toolbar-side-icon  @click.stop="drawer = !drawer" ></v-toolbar-side-icon>
            <v-toolbar-title>Title</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat v-if="!user" :to="{ name: 'login' }">Login</v-btn>
                <v-btn flat v-if="user" @click="logout">Logout</v-btn>
                <v-btn flat v-if="!user" :to="{ name: 'register' }" >Register</v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-content>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-content>
        <v-footer color="indigo">
            <v-layout
                justify-center
                align-center
            >
                <v-flex text-xs-center>
                    <span class="white--text"> Egor test task 2018</span>
                </v-flex>
            </v-layout>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        data: () => ({
            drawer: null,
        }),
        methods:{
            logout(){
                axios.post('/api/logout ')
                    .then(response => {
                        this.$store.commit('removeData');
                        Swal({
                            title: "Success",
                            text: response.data.data,
                            type: "success",
                        })
                        .then(()=>{
                            this.$router.go(-1);
                        });
                    })
                    .catch (errors  => {
                        Swal({
                            title: "Error",
                            text: errors.response.data.error,
                            type: "error",
                        })
                    });
            },
        },
        computed: {
            user() {
                return this.$store.state.user;
            }
        }
    }
</script>
