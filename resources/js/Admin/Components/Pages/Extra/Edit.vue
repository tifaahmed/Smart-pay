<template>
	<div class="container-fluid" >
        <div class="row row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

                <div class="card  box-shadow-0 " v-if="hasTranslatableFields">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Create {{TableName}} translatable fields</h4>
                    </div>
                    <b-card no-body>
                        <b-tabs  content-class="mt-3" card lazy >
                            <b-tab  v-for="( lang_val    , lang_key ) in Languages " :key="lang_key" >
                                <template #title>
                                    <b-spinner type="grow" small></b-spinner> <strong>{{lang_val}}</strong>
                                </template>

                                <div class="card-body pt-0">
                                    <div class="">

                                        <span v-for="( column_val , column_key ) in Columns" :key="column_key" >
                                            <InputsFactory 
                                                v-if="column_val.translatable"
                                                :Factorylable="column_val.header + ' ('+ lang_val +') '+( column_val.validation.required ? '*' : ''  )"  :FactoryPlaceholder="column_val.placeholder"         
                                                :FactoryType="column_val.type" :FactoryName="column_val.name+'['+lang_val+']'"  v-model ="RequestData[column_val.name][lang_val]"  
                                                :FactoryErrors="( ServerReaponse && Array.isArray( ServerReaponse.errors[column_val.name+'.'+lang_val]  )  ) ?  ServerReaponse.errors[column_val.name+'.'+lang_val] : null" 
                                            />
                                        </span> 

                                    </div>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </div>

                <div class="card  box-shadow-0 "  v-if="hasNoneTranslatableFields">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Create {{TableName}} fields</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="">
                            <span v-for="( column_val , column_key ) in Columns" :key="column_key" >
                                    <InputsFactory 
                                        v-if="!column_val.translatable"
                                        :Factorylable="column_val.header"  :FactoryPlaceholder="column_val.placeholder"         
                                        :FactoryType="column_val.type" :FactoryName="column_val.name"  v-model ="RequestData[column_val.name]"  
                                        :FactoryErrors="( ServerReaponse && Array.isArray( ServerReaponse.errors[column_val.name]  )  ) ?  ServerReaponse.errors[column_val.name] : null" 
                                    
                                        :FactorySelectOptions="column_val.type  === 'select' || column_val.type === 'Radio' ?
                                         column_val.SelectOptions : [] "  

                                        :FactorySelectStrings="column_val.type === 'select'? column_val.SelectStrings : []"   
                                        :FactorySelectForloopStrings="column_val.type === 'select'? column_val.SelectForloopStrings : []"   
                                        :FactorySelectForloopStringKeys="column_val.type === 'select'? column_val.SelectForloopStringKeys : []"  

                                        :FactorySelectImages="column_val.type === 'select'? column_val.SelectImages : []"   
                                        :FactorySelectForloopImages="column_val.type === 'select'? column_val.SelectForloopImages : []"  
                                        :FactorySelectForloopImageKeys="column_val.type === 'select'? column_val.SelectForloopImageKeys : []" 
                                    />
                            </span> 
                        </div>
                    </div>
                </div>

                <button  @click="FormSubmet()" class="btn btn-primary ">
                    Submit
                </button>
                
                <router-link style="color:#fff" 
                    :to = "{ 
                        name : TablePageName , 
                        query: { CurrentPage: this.$route.query.CurrentPage }  
                    }" 
                > 
                    <button type="button" class="btn btn-danger  ">
                        <i class="fas fa-arrow-left">
                                back
                        </i>
                    </button>
                </router-link>

                <div class="alert alert-danger " v-if="ServerReaponse && ServerReaponse.message"> 
                    {{ServerReaponse.message}}
                </div>

            </div>
        </div>
	</div>
</template>
<script>
import Model     from 'AdminModels/ExtraModel';
import ExtraCategoryModel     from 'AdminModels/ExtraCategoryModel';
import LanguageModel    from 'AdminModels/LanguageModel';
import StoreModel               from 'AdminModels/StoreModel';

import DataService    from '../../DataService';

import validation     from 'AdminValidations/ExtraValidation';
import InputsFactory     from 'AdminPartials/Components/Inputs/InputsFactory.vue'     ;

    export default {
        name:'Extra'+'Edit',

        components : { InputsFactory } ,

        async mounted() {
            this.start();
        },
        data( ) { return {
            TableName :'Extra',
            TablePageName :'Extra.All',

            Languages : [],
            all_extra_categories : {},
            all_stores : {},

            hasNoneTranslatableFields : 0,
            hasTranslatableFields : 0,
            
            Columns : [],

            ServerReaponse : {
                errors :  {},
                message : null,
            },

            // receive data to send to server 
            RequestData : {},
            // collect data to send to server 
            SendData : {},

        } } ,
        methods : {
            async start(){
                await this.GetlLanguages();
                    await this.GetlExtraCategories();
                    await this.GetlAllStores();

                let receivedData =   await this.show( ) ;
                this.Columns = [ 
                    { 
                        type: 'select',placeholder:'',header :'store', name : 'store_id' ,
                        translatable : false ,
                        data_value :receivedData.store  ,
                        validation:{required : true } ,
                        SelectOptions : this.all_stores, 
                        SelectStrings: [] ,SelectForloopStrings:['title'],SelectForloopStringKeys:['ar','en'],
                        SelectImages: ['image'] ,SelectForloopImages:[],SelectForloopImageKeys:[],
                    },
                    { 
                        type: 'Radio',placeholder:'status',header : 'status', name : 'status' ,
                        translatable : false , 
                        SelectOptions :['request_as_new','request_as_edit','active','deactivate','out_of_stock'],
                        data_value :receivedData.status  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'string',placeholder:'title',header : 'title', name : 'title' ,
                        translatable : true ,
                        data_value :receivedData.title  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'number',placeholder:'price',header : 'price', name : 'price' ,
                        translatable : false ,
                        data_value :receivedData.price  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'select',placeholder:'',header :'extra category', name : 'extra_category_id' ,
                        translatable : false ,
                        data_value :receivedData.extra_category  ,
                        validation:{required : true } ,
                        SelectOptions : this.all_extra_categories, 
                        SelectStrings: ['type'] ,SelectForloopStrings:['title'],SelectForloopStringKeys:['ar','en'],
                        SelectImages: [] ,SelectForloopImages:[],SelectForloopImageKeys:[],
                    },
                ];

                this.RequestData =  DataService.handleColumns(this.Columns,this.Languages);
                this.ServerReaponse.errors = DataService.handleErrorColumns(this.Columns,this.Languages);
                this.Columns.forEach(element => {
                    if (element.translatable) {
                        this.hasTranslatableFields = 1;
                    }else{
                        this.hasNoneTranslatableFields = 1;
                    }
                });
            },


            //  Handle Data before call the server 
                HandleData(){
                    for (var key in this.RequestData) {
                         this.SendData[key]        = this.RequestData[key] ;
                    }
                    this.SendData['store_id'] =  this.RequestData.store_id.id  ;

                    this.SendData['extra_category_id'] =  this.RequestData.extra_category_id.id  ;
                },
            //  Handle Data before call the server 

            DeleteErrors(){
                for (var key in this.ServerReaponse.errors) {
                    this.ServerReaponse.errors[key] = [];
                }
                this.ServerReaponse.message =null;
            },
            


            async FormSubmet(){
                //clear errors
                await this.DeleteErrors();                
                // valedate
                var check = await (new validation).validate(this.RequestData);
                if( check ){// if there is error from my file
                     this.ServerReaponse = check; // error from my file
                }else{ // run the form
                        
                    await this.HandleData();  // get id from objects
                     this.SubmetRowButton();  // succes from file
                }
            },


            // get data
                async GetlAllStores(){
                    this.all_stores = (await this.AllStores()).data.data;
                },
                async GetlExtraCategories(){
                    this.all_extra_categories = (await this.AllExtraCategories()).data.data;
                },
                async GetlLanguages(){
                    this.Languages  = ( await this.AllLanguages() ).data; // all languages
                },
            // get data

            async SubmetRowButton(){
                this.ServerReaponse = null;
                let data = await this.update()  ; // send update request
                if(data && data.errors){// stay and show error
                    this.ServerReaponse = data ;//error from the server
                }else{//return to the Table
                    this.ReturnToTablePag();//success from server
                }
            },
            async ReturnToTablePag( ) {
                return this.$router.push({ 
                    name: this.TablePageName , 
                    query: { CurrentPage: this.$route.query.CurrentPage } 
                })
            },


            // modal
                AllStores(){
                    return  (new StoreModel).all()  ;
                },
                AllExtraCategories(){
                    return  (new ExtraCategoryModel).all()  ;
                },
                AllLanguages(){
                    return  (new LanguageModel).all()  ;
                },
                async show( ) {
                    return ( await (new Model).show( this.$route.params.id) ).data.data[0] ;
                },
                update(){
                    return (new Model).update(this.$route.params.id , this.SendData)  ;
                }
                
            // modal


        }
    }
</script>