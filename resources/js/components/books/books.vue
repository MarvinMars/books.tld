<template>
<v-container grid-list-md text-xs-center>
    <v-layout row wrap>
        <v-flex xs12>
            <div v-if="error" class="error">
                <p>{{ error }}</p>
                <p>
                    <button @click.prevent="fetchData">
                        Try Again
                    </button>
                </p>
            </div>
            <v-list v-if="books" three-line>
                <v-list-tile
                    v-for="book in books"
                    :key="book.id"
                    avatar
                    @click=""
                    :to="{ name: 'book', params: { 'bookId' : book.id } } "
                >
                    <v-list-tile-avatar>
                        <img :src="'https://picsum.photos/10/10/?random&&blur&&'+book.id">
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title v-html="book.name"></v-list-tile-title>
                        <v-list-tile-sub-title v-html="'ISBN: '+book.isbn" class="text--primary"></v-list-tile-sub-title>
                        <v-list-tile-action-text v-show="!book.deleted_at">
                            <span>Created: {{book.created_at}}</span> - <span>Updated: {{book.updated_at}} </span>
                        </v-list-tile-action-text>
                        <v-list-tile-action-text v-if="book.deleted_at">
                            Deleted: {{book.deleted_at}}
                        </v-list-tile-action-text>
                    </v-list-tile-content>
                </v-list-tile>
                </v-list>
            <div class="text-xs-center" v-if="books">
                <v-pagination
                    v-model="page"
                    :length="last_page"
                    circle
                ></v-pagination>
            </div>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
    const getBooks = (page, callback) => {
        const params = { page };
        axios.get('/api/books', { params })
            .then(response => {
                callback(null, response.data);
            })
            .catch(error => {
                callback(error, error.response.data);
            });
    };
    export default {
        data: () => ({
            books: [],
            meta: null,
            last_page:null,
            page:null,
            error: null,
        }),
        beforeRouteEnter (to, from, next) {
            getBooks(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        beforeRouteUpdate (to, from, next) {
            getBooks(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },
        methods:{
            setData(err, { data: books, links, meta }) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.books = books;
                    this.meta = meta;
                    this.last_page = meta.pagination.total_pages;
                    this.page = meta.pagination.current_page;
                }
            },
        },
        watch:{
            page: function () {
                this.$router.push({ name: 'books', query: { page: this.page } });
            }
        }
    }
</script>
