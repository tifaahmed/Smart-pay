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
import Model     from 'AdminModels/StoreModel';
import LanguageModel    from 'AdminModels/LanguageModel';

import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"Store"+"Show",

    mounted() {
        this.initial();
        this.tableColumns();
    },
    components:{
        ColumsIndex
    },
    data( ) { return {
        TableName :'Store',
        TablePageName :'Store.All',

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
                    type: 'MultiSelectForloop'   ,header : 'food_sections' , name : 'food_sections'            , 
                    loopOnColumn:[
                        { name : 'id' , type: 'String'    } ,
                        { name : 'title' , type: 'Forloop' ,secondLoopOnColumn:this.Languages  } ,
                        { name : 'image' , type: 'Image'   } ,
                    ] ,
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
                    type: 'Image'   ,header : 'image'             , name : 'image'            , 
                    loopOnColumn:this.Languages ,  default : null
                } ,
                { 
                    type: 'Forloop'   ,header : 'title'             , name : 'title'            , 
                    loopOnColumn:this.Languages ,  default : null
                } ,
                { 
                    type: 'String'   ,header : 'delevery fee'    , name : 'delevery_fee'     ,
                    default : null
                } ,
                { 
                    type: 'Forloop'   ,header : 'description'        , name : 'description'            , 
                    invisible : true ,loopOnColumn:this.Languages ,  default : null
                } ,
                { 
                    type: 'String'   ,header : 'phone'    , name : 'phone'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'status'    , name : 'status'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'latitude'    , name : 'latitude'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'longitude'    , name : 'longitude'     ,
                    default : null
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
