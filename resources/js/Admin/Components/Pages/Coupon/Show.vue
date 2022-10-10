<template>
    <div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-md-nowrap">
                            <tbody>
                                <tr  v-for="( column_val , key    )  in Columns" :key="key" class="teeee" >
                                    <th class="never-hide"> {{column_val.header}}  </th>
                                    <td class="never-hide"> 
                                        <ColumsIndex  
                                            :ValueColumn="TableRows[column_val.name]"   
                                            :typeColumn="column_val.type" 
                                            :LoopOnColumn="column_val.loopOnColumn"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <router-link style="color:#fff" 
                            :to = "{ 
                                name : TablePageName , 
                                query: { CurrentPage: this.$route.query.CurrentPage }  
                            }" >                         
                            <button type="button" class="btn btn-danger  ">
                                <i class="fas fa-arrow-left">
                                        back
                                </i>
                            </button>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Model     from 'AdminModels/CouponModel';
import LanguageModel    from 'AdminModels/LanguageModel';

import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"Coupon"+"Show",

    mounted() {
        this.initial();
        this.tableColumns();
    },
    components:{
        ColumsIndex
    },
    data( ) { return {
        TableName :'',
        TablePageName :'Coupon.All',

        Columns :  [],
        TableRows : [],
    } 
    } ,
    methods : {

        // get data
            async initial( ) {
                this.TableRows  = ( await this.Show(this.$route.params.id) ) .data.data[0] ;
            },
            async GetlLanguages(){
                this.Languages  = ( await this.AllLanguages() ).data; // all languages ['ar','en']
            },
        // get data

        async tableColumns(){
            await this.GetlLanguages();
            this.Columns = [
                { 
                    type: 'Router'    ,header : 'id'                , name : 'id'               ,
                    default : null
                } ,
                
                { 
                    type: 'SelectForloop'   ,header : 'user' , name : 'user'            , 
                    loopOnColumn:[
                        { name : 'id' , type: 'String'   } ,
                        { name : 'avatar' , type: 'Image'   }  ,
                        { name : 'first_name' , type: 'String' } ,
                    ] ,
                } ,
                { 
                    type: 'SelectForloop'   ,header : 'store' , name : 'user'            , 
                    loopOnColumn:[
                        { name : 'id' , type: 'String'   } ,
                        { name : 'image' , type: 'Image'   }  ,
                        { name : 'title' , type: 'String' } ,
                    ] ,
                } ,
                { 
                    type: 'Forloop'   ,header : 'title'             , name : 'title'            , 
                    loopOnColumn:this.Languages ,  default : null
                } ,
                { 
                    type: 'String'   ,header : 'code'    , name : 'code'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'type'    , name : 'type'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'usage limit'    , name : 'usage_limit'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'percent limit'    , name : 'percent_limit'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'start date'    , name : 'start date'     ,
                    default : null , invisible : true
                } ,
                { 
                    type: 'String'   ,header : 'end date'    , name : 'end_date date'     ,
                    default : null , invisible : true
                } ,
                { 
                    type: 'Date'      ,header : 'created'            , name : 'created_at'        ,
                     default : null
                } ,
                { 
                    type: 'Date'      ,header : 'updated'            , name : 'updated_at'        ,
                    invisible : true  ,default : null
                } ,
            ];
        },

        
        // modal
            AllLanguages(){
                return  (new LanguageModel).all()  ;
            },
            async Show(id) {
                return  ( (new Model).show(id) )
            },
        // modal
    }       
}
</script>
