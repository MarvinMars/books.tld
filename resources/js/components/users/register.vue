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
                                          name="name"
                                          label="Name*"
                                          type="text"
                                          v-model="name"
                            ></v-text-field>
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
                            <v-text-field id="password_confirm"
                                          prepend-icon="lock"
                                          name="password_confirm"
                                          label="Password Confirm*"
                                          type="password"
                                          v-model="password_confirm"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <div v-if="errors">
                        <v-alert :value="true" v-for="(error,index) in errors" :key="index" type="error">
                            <span  v-for="(message,index) in error" :key="index">{{message}}</span>
                        </v-alert>
                    </div>
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
            errors:[],
            name: null,
            email: null,
            password: null,
            password_confirm: null
        }),
        methods:{
            login() {
                axios.post('/api/register ', {
                    'name':this.name,
                    'email':this.email,
                    'password':this.password,
                    'password_confirmation':this.password_confirm,
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
                    this.errors = errors.response.data.errors;
                    Swal({
                        title: "Error",
                        text: errors.response.data.message,
                        type: "error",
                    })
                });
            }
        },
    }
</script>
