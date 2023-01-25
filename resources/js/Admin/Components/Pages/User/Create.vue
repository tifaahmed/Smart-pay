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
                                    :Factorylable="column_val.header +( column_val.validation.required ? '*' : ''  )"   :FactoryPlaceholder="column_val.placeholder"         
                                    :FactoryType="column_val.type" :FactoryName="column_val.name"  v-model ="RequestData[column_val.name]"  
                                    :FactoryErrors="( ServerReaponse && Array.isArray( ServerReaponse.errors[column_val.name]  )  ) ?  ServerReaponse.errors[column_val.name] : null" 
                                    
                                    :FactorySelectOptions="column_val.type  === 'select' || column_val.type  === 'multiSelect' || column_val.type === 'Radio' ?
                                        column_val.SelectOptions : [] "  

                                    :FactorySelectStrings="column_val.type === 'select'  || column_val.type  === 'multiSelect'? column_val.SelectStrings : []"   
                                    :FactorySelectForloopStrings="column_val.type === 'select'  || column_val.type  === 'multiSelect'? column_val.SelectForloopStrings : []"   
                                    :FactorySelectForloopStringKeys="column_val.type === 'select' || column_val.type  === 'multiSelect'? column_val.SelectForloopStringKeys : []"  

                                    :FactorySelectImages="column_val.type === 'select' || column_val.type  === 'multiSelect'? column_val.SelectImages : []"   
                                    :FactorySelectForloopImages="column_val.type === 'select' || column_val.type  === 'multiSelect'? column_val.SelectForloopImages : []"  
                                    :FactorySelectForloopImageKeys="column_val.type === 'select' || column_val.type  === 'multiSelect'? column_val.SelectForloopImageKeys : []" 
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
import Model     from 'AdminModels/UserModel';
import RoleModel     from 'AdminModels/RoleModel';

import DataService    from '../../DataService';

import validation     from 'AdminValidations/UserValidation';
import InputsFactory     from 'AdminPartials/Components/Inputs/InputsFactory.vue'     ;

    export default    {
        name:'User'+'Create',
        components : { InputsFactory } ,

        async mounted() {
            await this.start();
        },
        data( ) { return {
            TableName :'User',
            TablePageName :'User.All',

            Languages : [],
            all_rolrs : {},

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

                // get data
                    await this.GetlAllRoles();
                // get data

                this.Columns = [
                    { 
                        type: 'multiSelect',placeholder:'',header :'roles', name : 'role_ids' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : true } ,
                        SelectOptions : this.all_rolrs, 
                        SelectStrings: ['name'] ,SelectForloopStrings:[],SelectForloopStringKeys:[],
                        SelectImages: [] ,SelectForloopImages:[],SelectForloopImageKeys:[],
                    },
                    { 
                        type: 'string',placeholder:'first_name',header : 'first_name', name : 'first_name' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'string',placeholder:'last_name',header : 'last_name', name : 'last_name' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'string',placeholder:'password',header : 'password', name : 'password' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'file',placeholder:null,header :'avatar', name : 'avatar' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'string',placeholder:'***@***.***',header : 'email', name : 'email' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'datetime-local',placeholder:'email_verified',header : 'email_verified_at', name : 'email_verified_at' ,
                        translatable : false , 
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'string',placeholder:'phone',header : 'phone', name : 'phone' ,
                        translatable : false ,
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'datetime-local',placeholder:'phone verified',header : 'phone_verified_at', name : 'email_verified_at' ,
                        translatable : false , 
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'Radio',placeholder:'gender',header : 'gender', name : 'gender' ,
                        translatable : false , SelectOptions :['boy','girl'],
                        data_value : null  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'string',placeholder:'latitude',header : 'latitude', name : 'latitude' ,
                        translatable : false , 
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'string',placeholder:'longitude',header : 'longitude', name : 'longitude' ,
                        translatable : false , 
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'string',placeholder:'fcm_token',header : 'fcm_token', name : 'fcm_token' ,
                        translatable : false , 
                        data_value : null  ,
                        validation:{required : false } 
                    },
                    { 
                        type: 'string',placeholder:'pin_code',header : 'pin_code', name : 'pin_code' ,
                        translatable : false , 
                        data_value : null  ,
                        validation:{required : true } 
                    },
                    { 
                        type: 'date',placeholder:'birthdate',header : 'birthdate', name : 'birthdate' ,
                        translatable : false , 
                        data_value : null  ,
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

            //  Handle Data before call the server 
                HandleData(){
                    for (var key in this.RequestData) {
                         this.SendData[key]        = this.RequestData[key] ;
                    }
                    if (this.RequestData.role_ids) {
                        var arr_hold = [];
                        for (var role_key in this.RequestData.role_ids) {
                        arr_hold[role_key] = this.RequestData.role_ids[role_key].id  ;
                        }
                        this.SendData.role_ids  =arr_hold;
                    }
                },
            //  Handle Data before call the server



            // get data
                async GetlAllRoles(){
                    this.all_rolrs = (await this.AllRoles()).data.data;
                },
            // get data



            // model 
                AllRoles(){
                    return  (new RoleModel).all()  ;
                },
                store(){
                    return (new Model).store(this.SendData)  ;
                },
            // model 

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

            async ReturnToTablePage( ) {
                return this.$router.push({ 
                    name: this.TablePageName , 
                    query: { CurrentPage: this.$route.query.CurrentPage } 
                })
            },

        },

    }
</script>