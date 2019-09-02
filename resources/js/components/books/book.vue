<template>
    <v-card
        class="mx-auto"
        color="#26c6da"
        dark
        v-if="book"
    >
        <v-card-title>
            <v-btn dark icon @click="back">
                <v-icon>chevron_left</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <span class="title font-weight-light">ISBN: {{book.isbn}}</span>
        </v-card-title>

        <v-card-text class="headline font-weight-bold">
            {{book.name}}
        </v-card-text>
        <v-spacer></v-spacer>
        <v-card-text class="headline font-weight-bold">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </v-card-text>
        <v-card-actions>
            <v-list-tile class="grow">
                <v-list-tile-avatar color="grey darken-3"  v-if="book.user">
                    <v-img
                        class="elevation-6"
                        :src="'https://picsum.photos/20/20/?random&&blur&&'+$route.params.bookId"
                    ></v-img>
                </v-list-tile-avatar>

                <v-list-tile-content v-if="book.user">
                    <v-list-tile-sub-title>{{book.user.name}}</v-list-tile-sub-title>
                    <v-list-tile-sub-title>{{book.user.email}}</v-list-tile-sub-title>
                </v-list-tile-content>
                <v-card-actions>
                    <v-btn flat :to="{ name: 'createBook', params: { 'bookId' : book.id } } ">
                        <v-icon class="mr-1">fas fa-plus</v-icon>
                    </v-btn>
                    <v-btn flat
                           v-if="(user && book.user && (book.user.id == user.id)) || ( user &&  user.role == 'admin')"
                           :to="{ name: 'editBook', params: { 'bookId' : book.id } } "
                    ><v-icon class="mr-1">fas fa-edit</v-icon>
                    </v-btn>
                    <v-btn flat
                           v-if="(user && book.user && (book.user.id == user.id)) || ( user &&  user.role == 'admin')"
                           :to="{ name: 'deleteBook', params: { 'bookId' : book.id } } "
                    ><v-icon class="mr-1">fas fa-trash</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-list-tile>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        data: () => ({
            book: null,
            fab:false
        }),
        mounted(){
            var _this = this;
            axios.get('/api/books/'+_this.$route.params.bookId)
                .then(response => {
                    _this.book = response.data.book;
                })
                .catch (errors => {
                    Swal({
                        title: "Error",
                        text: errors.response.data.message,
                        type: "error",
                    })
                });
        },
        methods:{
            back(){
                this.$router.go(-1);
            }
        },
        computed: {
            user() {
                return this.$store.state.user;
            }
        }
    }
</script>
