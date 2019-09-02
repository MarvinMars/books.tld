<template></template>
<script>
    export default {
        name: "delete",
        mounted(){
         this.showPopup();
        },
        methods:{
            showPopup(){
                var _this = this;
                axios.get('/api/books/'+_this.$route.params.bookId)
                    .then(response => {
                        _this.book = response.data.book.name;
                        Swal({
                            title: "Delete?",
                            text: response.data.book.name+' '+response.data.book.isbn,
                            type: "question",
                            showCancelButton:true,
                        })
                        .then((value)=>{
                            if(value.value==true){
                                _this.deleteBook();
                            }else{
                                _this.$router.push({name:'books'});
                            }
                        });
                    })
                    .catch (errors  => {
                        Swal({
                            title: "Error",
                            text: errors.response.data.error,
                            type: "error",
                        })
                        .then(()=>{
                            _this.$router.push({ name:'books'});
                        });
                    });
            },
            deleteBook(){
                axios({
                    method:'delete',
                    url:'/api/books/'+this.$route.params.bookId,
                    headers:{'Authorization':'Bearer '+this.$store.state.user.api_token}
                })
                .then(response => {
                    Swal({
                        title: "Success",
                        text: 'Book deleted',
                        type: "success",
                    })
                    .then(()=>{
                        this.$router.push({name:'books'});
                    });
                })
                .catch (errors  => {
                    this.errors = errors.response.data.errors;
                    Swal({
                        title: "Error",
                        text: errors.response.data.message,
                        type: "error",
                    })
                    .then(()=>{
                        this.$router.push({name:'books'});
                    });
                });
            }
        }
    }
</script>
