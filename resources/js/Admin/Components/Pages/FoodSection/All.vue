<template>
    <div class="row row-sm">

        <div class="container-fluid row" > 
            <a href="#">
                 <i v-on:click="seen = !seen" class="fa fa-filter" aria-hidden="true"></i>
            </a>

            <b-row v-if="seen" align-v="stretch" align-h="around">
                <b-col  xs="12" sm="6" md="5" lg="4" xl="3">
                    <b-input-group prepend="id"   class="">
                        <b-form-input   @change="initial()"  v-model="filter.id"  ></b-form-input>
                    </b-input-group>
                </b-col>
            </b-row>

        </div>

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
                                            :ValueColumn="row[column.name] ? row[column.name] : column.default "   
                                            :typeColumn="column.type" 
                                            :LoopOnColumn="column.loopOnColumn"
                                            @SendRowData ="SendRowData(row)"  
                                        />
                                    </td>
                                    <td>
                                        <TableControllers 
                                            :controller_buttons = "controller_buttons"
                                            :RowId="row.id" 
                                            :CurrentPage="TableRows.meta ? TableRows.meta.current_page : 1" 
                                            @SendRowData="SendRowData(row)"
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
                            <!-- eslint-disable -->
                            <span slot="prev-nav" >  < </span>
                            <span slot="next-nav" >  > </span>
                            <!-- eslint-disable -->
                        </pagination>
                        <ModalIndex  
                            :Columns="Columns" 
                            :SingleTableRows="SingleTableRows" 
                            :TableRows="TableRows" 
                            @DeleteRowButton="DeleteRowButton"
                            :CurrentPage="TableRows.meta ? TableRows.meta.current_page: 1" 
                            :controller_buttons = "controller_buttons"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Model     from 'AdminModels/FoodSectionModel';
import LanguageModel    from 'AdminModels/LanguageModel';

import pagination           from 'laravel-vue-pagination';
import ModalIndex           from 'AdminPartialsModal/MainModel.vue'     ;
import TableControllers     from 'AdminPartials/Components/Controllers/TableControllers.vue'     ;
import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"FoodSection"+"All",
    components:{
        pagination,ModalIndex,TableControllers,ColumsIndex
    },

    data( ) { return {
        seen: false,   
        filter :{  id : null  },

        TableName :'FoodSection',
        Languages : [],

        TableRows  : {},
        SingleTableRows : {},

        Columns :  [],       
        controller_buttons   : [ 'edit','delete','show' ] ,

        PerPage  : 5
    } },
    
    mounted() {
        this.initial( this.$route.query.CurrentPage );
        this.tableColumns();
    },

    methods : {
        async initial(page){
            this.TableRows  = ( await this.Collection(page) ).data ;
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
                    type: 'Image'   ,header : 'image'             , name : 'image'            , 
                    loopOnColumn:this.Languages ,  default : null
                } ,
                { 
                    type: 'Forloop'   ,header : 'title'             , name : 'title'            , 
                    loopOnColumn:this.Languages ,  default : null
                } ,
                { 
                    type: 'Forloop'   ,header : 'description'        , name : 'description'            , 
                    loopOnColumn:this.Languages ,  default : null
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

        // model 
            AllLanguages(){
                return  (new LanguageModel).all()  ;
            },
            Collection(page = 1){
                return  (new Model).collection(page,this.PerPage,this.filter)  ;
            },
            Delete(id){
                return (new Model).deleteRow(id)  ;
            },
        // model 

        async DeleteRowButton(page,id){
            let  data = await this.Delete(id);
            await this.initial(page);
            this.CloseModal();
        },



        // modal
            SendRowData(row){
                this.SingleTableRows = row;
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