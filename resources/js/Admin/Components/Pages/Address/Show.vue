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
import Model     from 'AdminModels/AddressModel';
import LanguageModel    from 'AdminModels/LanguageModel';

import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"Address"+"Show",

    mounted() {
        this.initial();
        this.tableColumns();
    },
    components:{
        ColumsIndex
    },
    data( ) { return {
        TableName :'Address',
        TablePageName :'Address.All',

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
                    default : null , searchable : true
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
                    type: 'SelectForloop'   ,header : 'city' , name : 'city'            , 
                    loopOnColumn:[
                        { name : 'id' , type: 'String'   } ,
                        { name : 'name' , type: 'Forloop'  , secondLoopOnColumn :this.Languages }  ,
                    ] ,
                } ,
                { 
                    type: 'String'   ,header : 'city name'    , name : 'city_name'     ,
                    default : null,
                } ,

                { 
                    type: 'String'   ,header : 'address'    , name : 'address'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'department'    , name : 'department'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'house'    , name : 'house'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'street'    , name : 'street'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'floor'    , name : 'floor'     ,
                    default : null,
                } ,
                
                { 
                    type: 'String'   ,header : 'note'    , name : 'note'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'type'    , name : 'type'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'latitude'    , name : 'latitude'     ,
                    default : null,
                } ,
                { 
                    type: 'String'   ,header : 'longitude'    , name : 'longitude'     ,
                    default : null,
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
