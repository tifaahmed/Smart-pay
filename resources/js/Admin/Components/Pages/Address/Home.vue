<template>
    <!-- main-header opened -->
    <div>
 
        <!-- breadcrumb -->
        <div class="container-fluid" >
            <div class="breadcrumb-header justify-content-between" style="justify-content: space-between !important; margin-top: 10px;">
                
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">{{TableName}} Table</h4>
                        <!-- <span class="text-muted mt-1 tx-13 mr-2 mb-0"></span> -->
                    </div>
                </div>

                <div class="d-flex my-xl-auto right-content">
                    <div class="pr-1 mb-xl-0">
                        <router-link style="color:#fff" 
                        :to = "{ 
                            name : TableName+'.Create' , 
                            query: { CurrentPage: this.$route.query.CurrentPage }  
                        }" > 
                            <button type="button" class="btn btn-success  ">
                                <i class="fa fa-plus">
                                        Create New
                                </i>
                            </button>
                        </router-link>
                    </div>
                    <div class="pr-1 mb-xl-0">
                        <router-link style="color:#fff" 
                        :to = "{ 
                            name : TableName+'.All' , 
                            query: { CurrentPage: 1 }  
                        }" > 
                            <button type="button" class="btn btn-primary  ">
                                <i class="fas fa-list-ol">
                                        Show all
                                </i>
                            </button>
                        </router-link>
                    </div>

                    <!-- trash -->
                    <div class="pr-1 mb-xl-0">
                        <router-link style="color:#fff" 
                        :to = "{ 
                            name : TableName+'.AllTrash' , 
                            query: { CurrentPage: 1 }  
                        }" > 
                            <button type="button" class="btn btn-danger  ">
                                <i class="fas fa-trash-alt">
                                        trash
                                </i>
                            </button>
                        </router-link>
                    </div>
                    <!-- trash -->

                </div>
            </div>
        </div>  

        <!-- breadcrumb -->

        <router-view></router-view>
    </div>



</template>
<script>
    export default {
        name:'Address'+'Home',
        mounted() {
        },
        components:{
        },
        data( ) { return {
            TableName :'Address',
        } } ,
    }
</script>