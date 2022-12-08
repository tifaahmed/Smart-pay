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
                                    v-if="column_val.translatable == false"
                                    :Factorylable="column_val.header"  :FactoryPlaceholder="column_val.placeholder"         
                                    :FactoryType="column_val.type" :FactoryName="column_val.name"  v-model ="RequestData[column_val.name]"  
                                    :FactoryErrors="( ServerReaponse && Array.isArray( ServerReaponse.errors[column_val.name]  )  ) ?  ServerReaponse.errors[column_val.name] : null" 
                                    
                                    :FactorySelectOptions="column_val.SelectOptions ? column_val.SelectOptions : [] "  

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
import Model     from 'AdminModels/SubscriptionModel';
import StoreModel    from 'AdminModels/StoreModel';
import LanguageModel    from 'AdminModels/LanguageModel';

import DataService    from '../../DataService';

import validation     from 'AdminValidations/ExtraValidation';
import InputsFactory     from 'AdminPartials/Components/Inputs/InputsFactory.vue'     ;

    export default    {
        name:'Subscription'+'Create',
        components : { InputsFactory } ,

        async mounted() {
            this.start();
        },
        data( ) { return {
            // titles
            TableName :'Subscription',
            TablePageName :'Subscription.All',

            // get data 
            Languages : [],
            all_stores : {},

            // tabs
            hasNoneTranslatableFields : 0,
            hasTranslatableFields : 0,

            // inputs
            Columns : [],

            // errors from (server & vue)
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
                // get data
                    await this.GetlLanguages();
                    await this.GetlStores();
                // get data

                this.Columns = [ 
                    { 
                        type: 'select',placeholder:'',header :'store', name : 'store_id' ,
                        translatable : false ,
                        data_value :null  ,
                        validation:{required : true } ,
                        SelectOptions : this.all_stores, 
                        SelectStrings: ['type'] ,SelectForloopStrings:['title'],SelectForloopStringKeys:['ar','en'],
                        SelectImages: ['image'] ,SelectForloopImages:[],SelectForloopImageKeys:[],
                    },
                    { 
                        type: 'date',placeholder:null,header : 'start date', name : 'start_date' ,
                        translatable : false ,
                        data_value : DataService.now(),
                        validation:{required : true } 
                    },
                    { 
                        type: 'date',placeholder:null,header : 'end date', name : 'end_date' ,
                        translatable : false ,
                        data_value :null  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'number',placeholder:null,header : 'month number', name : 'month_number' ,
                        translatable : false ,
                        data_value :1  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'Radio',placeholder:null,header : 'status', name : 'subscription_status' ,
                        translatable : false , 
                        SelectOptions :['pending', 'accepted', 'rejected' ,'canceled'],
                        data_value :'pending'  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'Radio',placeholder:null,header : 'payment type', name : 'payment_type' ,
                        translatable : false , 
                        SelectOptions :[ 'visa' , 'cash'],
                        data_value :'cash'  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'Radio',placeholder:null,header : 'payment card status', name : 'payment_card_status' ,
                        translatable : false , 
                        SelectOptions :[  'paid' , 'pindding' , 'rejected' , 'canceled' ],
                        data_value :null  ,
                        validation:{required : false } 
                    },
                    
                    { 
                        type: 'textarea',placeholder:null,header : 'payment_card_data', name : 'payment_card_data' ,
                        translatable : false ,
                        data_value :null  ,
                        validation:{required : false } 
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


            DeleteErrors(){
                for (var key in this.ServerReaponse.errors) {
                    this.ServerReaponse.errors[key] = [];
                }
                this.ServerReaponse.message =null;
            },

            async FormSubmet(){
                // clear errors
                await this.DeleteErrors();
                // front end valedate
                var check = await (new validation).validate(this.RequestData,this.Columns,this.Languages);
                if( check ){ // if there is error
                    this.ServerReaponse = check;
                }
                // front end valedate
                else{
                    await this.HandleData();  // get id from objects
                    this.SubmetRowButton();// run the form
                }
            },

            

            // get data
                async GetlStores(){
                    this.all_stores = (await this.AllStores()).data.data;
                },
                async GetlLanguages(){
                    this.Languages  = ( await this.AllLanguages() ).data; // all languages
                },
            // get data

            // model 
                AllStores(){
                    return  (new StoreModel).all()  ;
                },
                AllLanguages(){
                    return  (new LanguageModel).all()  ;
                },
                store(){
                    return (new Model).store(this.SendData)  ;
                },
            // model 
            
            //  Handle Data before call the server 
                HandleData(){
                    for (var key in this.RequestData) {
                         this.SendData[key]        = this.RequestData[key] ;
                    }
                    this.SendData['store_id'] =  this.RequestData.store_id.id  ;
                },
            //  Handle Data before call the server 

            // call the server
                async SubmetRowButton(){
                    this.ServerReaponse = null;

                    let data = await this.store()  ;
                    if(data && data.errors)
                    {//error from server
                        this.ServerReaponse = data    ;
                    }else{//success from server
                        this.ReturnToTablePage();
                    }
                },
            // call the server

            // redirect 
                async ReturnToTablePage( ) {
                    return this.$router.push({ 
                        name: this.TablePageName , 
                        query: { CurrentPage: this.$route.query.CurrentPage } 
                    })
                },
            // redirect 

        },

    }
</script>