<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md6>
                <v-card class="elevation-12">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Create Book</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                            <v-text-field prepend-icon="fas fa-signature"
                                          name="name"
                                          label="Name*"
                                          type="text"
                                          v-model="name"
                            ></v-text-field>
                            <v-text-field id="password"
                                          prepend-icon="fas fa-barcode"
                                          name="isbn"
                                          label="Isbn*"
                                          type="text"
                                          v-model="isbn"
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
                        <v-btn color="primary" @click="create">Create</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data: () => ({
            name: null,
            isbn: null,
            errors:[],
        }),
        beforeEnter: (to, from, next) => {
            if (this.$store.state.user) {
                next({ name: 'home'});
            } else {
                next();
            }
        },
        methods:{
            create() {
                this.errors = [];
                axios({
                    method:'post',
                    url:'/api/books ',
                    data:{
                        'name':this.name,
                        'isbn': this.isbn,
                    },
                    headers:{'Authorization':'Bearer '+this.$store.state.user.api_token}
                })
                .then(response => {
                    Swal({
                        title: "Success",
                        text: 'Book created',
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
