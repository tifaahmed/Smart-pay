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
                                        v-if="!column.invisible"
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
                                        <TrashedControllers 
                                            :controller_buttons = controller_buttons
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
                            :controller_buttons="controller_buttons" 
                            :Columns="Columns" 
                            :TableRows="TableRows" 
                            :SingleTableRows="SingleTableRows" 
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
import Model     from 'AdminModels/OrderModel';

import pagination           from 'laravel-vue-pagination';
import ModalIndex           from 'AdminPartialsModal/MainModel.vue'     ;
import TrashedControllers   from 'AdminPartials/Components/Controllers/TrashedControllers.vue'     ;
import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"Order"+"AllTrash",
    components:{
        pagination,ModalIndex,TrashedControllers,ColumsIndex
    },


    data( ) { return {
        filter :{  id : null  },

        TableName :'Order',
        Languages : [],

        TableRows  : {},
        SingleTableRows : {},

        Columns :  [],       
        controller_buttons   : [ 'edit','delete','show' ] ,
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
        async tableColumns(){
            this.Columns = [
                { 
                    type: 'Router'    ,header : 'id'                , name : 'id'               ,
                    default : null
                } ,
                { 
                    type: 'MultiSelectForloopModal'   ,header : 'stores' , name : 'order_stores'            , 
                    loopOnColumn:[
                        { name : 'id' , type: 'String'    } ,
                        { name : 'order_status' , type: 'String'    } ,
                        { name : 'store_title' , type: 'String'    } ,
                    ] ,
                } ,
                { 
                    type: 'String'   ,header : 'order code'    , name : 'order_code'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'total'    , name : 'total'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'payment card status' , name : 'payment_card_status'     ,
                    default : null
                } ,
                { 
                    type: 'String'   ,header : 'payment type' , name : 'payment_type'     ,
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
        // model 
            Collection(page = 1){
                return  (new Model).CollectionTrash(page,this.PerPage,this.filter)  ;
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