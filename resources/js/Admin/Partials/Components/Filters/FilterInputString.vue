<template>
        <b-form-input 
            type="text" :placeholder="PropPlaceholder"  
            :id="PropName" :name="PropName"  
            v-model="data" 
            @change="change()"
        />
</template>

 
<script> 
export default {
    data( ) { return {
    	data : this.value
    } } ,
    props   : {
    	PropLable :null,
    	PropPlaceholder :null,
    	PropName : null,
        value :null,
    } ,
    watch   : {

    	value( ) {
    	    this.data = this.value ;
    	}
    } ,
    methods : {
        change(   ) {
        	this.$emit( 'input'  , String( this.data ) ) ;
        	this.$emit( 'change' , String( this.data ) ) ;        
        }
    } ,

} </script>