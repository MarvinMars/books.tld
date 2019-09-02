<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
             <v-flex xs12 sm8 md6>
                <v-card class="elevation-12">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Login form</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                            <v-text-field prepend-icon="person"
                                          name="login"
                                          label="Login*"
                                          type="text"
                                          v-model="email"
                            ></v-text-field>
                            <v-text-field id="password"
                                          prepend-icon="lock"
                                          name="password"
                                          label="Password*"
                                          type="password"
                                          v-model="password"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="login">Login</v-btn>
                    </v-card-actions>
                </v-card>
             </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data: () => ({
            email: null,
            password: null
        }),
        methods:{
            login() {
                axios.post('/api/login ', {
                    'email':this.email,
                    'password':this.password,
                })
                    .then(response => {
                        this.$store.commit('setData',response.data.data);
                        Swal({
                            title: "Success",
                            type: "success",
                        })
                        .then(()=>{
                            this.$router.go(-1);
                        });
                    })
                    .catch (errors  => {
                        this.errors = errors.response.error;
                        Swal({
                            title: "Error",
                            text: errors.response.error,
                            type: "error",
                        })
                    });
            }
        },
    }
</script>
