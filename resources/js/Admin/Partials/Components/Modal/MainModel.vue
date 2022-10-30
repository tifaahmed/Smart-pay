<template>
	<div>
		<!-- modal delete-->
		    <ModalDelete  
				:Columns="Columns"   
				:controller_buttons="controller_buttons"   
				@DeleteButton="DeleteButton" 
			/>
		<!-- modal delete-->

		<!-- modal QuickView-->
		    <ModelQuickView 
			:Columns="Columns" 
			:CurrentPage="CurrentPage" 
			:SingleTableRows="SingleTableRows"
			:controller_buttons="controller_buttons"   
		/>
		<!-- modal QuickView -->

	</div>
</template>
<script>
import ModalDelete     from 'AdminPartialsModal/ModalDelete.vue'     ;
import ModelQuickView  from 'AdminPartialsModal/ModelQuickView.vue'     ;

export default {
			name:'MainModel',

	data( ) { return {
		
	} } ,
	components:{
	    ModelQuickView,ModalDelete
	},
	props   : {
		Columns :null,
		SingleTableRows :null,
		TableRows : null,
		CurrentPage : Number,
		controller_buttons: Array
	} ,

	methods    : {
	    DeleteButton( ) {
	    	var id   = this.SingleTableRows && this.SingleTableRows['id'] ? this.SingleTableRows['id'] : null;
	    	var CurrentPage = this.TableRows.meta.current_page ;
	        this.$emit( 'DeleteRowButton'  , CurrentPage, id ) ;
	    } ,
	}
}
  
</script>