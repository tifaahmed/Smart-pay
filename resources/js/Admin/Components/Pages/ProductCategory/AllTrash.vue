<template>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap">
                            <thead> 
                                <tr> 
                                    <!-- eslint-disable -->
                                    <th 
                                        v-for="( column , key    ) in Columns    " 
                                        :key="key   " 
                                        v-if="column && !column.invisible"
                                        v-text="column.header" 
                                    /> 
                                    <!-- eslint-disable -->
                                    <th  v-text="'controller'" />
                                </tr> 
                            </thead>
                            <tbody>
                                <tr v-for="( row    , rowkey ) in TableRows.data " :key="rowkey" >
                                    <td  v-for="( column , key    )  in Columns" :key="key" class="teeee" 
                                        v-if="column && !column.invisible"
                                    >
                                        <ColumsIndex  
                                            :ValueColumn="row[column.name]"   
                                            :typeColumn="column.type" 
                                            :LoopOnColumn="column.loopOnColumn"
                                            @SendRowData ="SendRowData(row)"  
                                        />
                                    </td>
                                    <td>
                                        <TrashedControllers 
                                            :RowId="row.id" 
                                            :CurrentPage="TableRows.meta ? TableRows.meta.current_page: 1" 
                                            @SendRowData="SendRowData(row)"
                                            @RestoreRowButton="RestoreRowButton"
                                            @DeleteRowButton="DeleteRowButton"
                                        />
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                        <pagination 
                            v-if="TableRows" 
                            :size="'default'" 
                            :align="'center'" 
                            :show-disabled="true" 
                            :limit="5" 
                            :data="TableRows" 
                            @pagination-change-page="initial"
                         >
                            <span slot="prev-nav" >  < </span>
                            <span slot="next-nav" >  > </span>
                        </pagination>
                        <ModalIndex  
                            :Columns="Columns" 
                            :TableRows="TableRows" 
                            @DeleteRowButton="DeleteRowButton"
                            :CurrentPage="TableRows.meta ? TableRows.meta.current_page: 1" 
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Model     from 'AdminModels/ProductCategoryModel';
import LanguageModel    from 'AdminModels/LanguageModel';

import pagination           from 'laravel-vue-pagination';
import ModalIndex           from 'AdminPartialsModal/MainModel.vue'     ;
import TrashedControllers   from 'AdminPartials/Components/Controllers/TrashedControllers.vue'     ;
import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"ProductCategory"+"AllTrash",
    components:{
        pagination,ModalIndex,TrashedControllers,ColumsIndex
    },

    data( ) { return {
        filter :{  id : null  },


        TableName :'ProductCategory'+'Trash',
        Languages : [],

        TableRows  : {},
        Columns :  [],       
        controller   : [
            { type: 'edit'    ,  invisible : true } ,
            { type: 'delete'  ,  invisible : true } ,
            { type: 'show'    ,  invisible : true } ,
        ] ,
        PerPage  : 10
    } },
    mounted() {
        this.initial( this.$route.query.CurrentPage );
        this.tableColumns();
    },

    methods : {
        async initial(page){
            this.TableRows  = ( await this.Collection(page) ).data
        },
        async GetlLanguages(){
            this.Languages  = ( await this.AllLanguages() ).data; // all languages ['ar','en']
        },
        async tableColumns(){
            await this.GetlLanguages();
            this.Columns = [
                { 
                    type: 'Router'    ,header : 'id'                , name : 'id'               ,
                    default : null
                } ,
                
                { 
                    type: 'Forloop'   ,header : 'title'             , name : 'title'            , 
                    loopOnColumn:this.Languages ,  default : null
                } ,
                
                { 
                    type: 'Date'      ,header : 'created'            , name : 'created_at'        ,
                    default : null
                } ,
                { 
                    type: 'Date'      ,header : 'updated'            , name : 'updated_at'        ,
                    default : null
                } ,
                { 
                    type: 'Date'      ,header : 'deleted'            , name : 'deleted_at'        ,
                    default : null
                } ,
            ];
        },
        // model 
            AllLanguages(){
                return  (new LanguageModel).all()  ;
            },
            Collection(page = 1){
                return  (new Model).CollectionTrash(page,this.PerPage)  ;
            },
            Delete(id){
                return (new Model).premanentlDeleteRow(id)  ;
            },
            Rstore(id){
                return (new Model).RstoreRow(id)  ;
            },
        // model 

        async DeleteRowButton(page,id){
            let  data = await this.Delete(id);
            await this.initial(page);
            this.CloseModal();
        },
        async RestoreRowButton(page,id){
            let  data = await this.Rstore(id);
            await this.initial(page);
        },
        // modal
            SendRowData(row){
                this.Columns.forEach(function (SingleRow) {
                    SingleRow.value = row[SingleRow.name] ;
                });
            },
            CloseModal(){
                var button = document.getElementById("close");
                button.click();
            },
        // modal



    }

}
</script>