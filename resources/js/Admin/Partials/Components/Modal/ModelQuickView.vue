<template>
	<div class="modal" id="modalShow" >
	    <div class="modal-dialog wd-xl-400" role="document">
	        <div class="modal-content">
	            <div class="modal-body pd-20 pd-sm-40 text-center" >

	            		<ModelRows 
							:Columns="Columns" 
							:SingleTableRows="SingleTableRows" 
						/>
						<TableControllers 
							:controller_buttons = "controller_buttons"
							:RowId="SingleTableRows &&  SingleTableRows['id'] ? SingleTableRows['id'] : null" 
							:CurrentPage="CurrentPage" 
							@SendRowData="SendRowData(SingleTableRows)"
						/>

	                
	            </div><!-- body -->
	        </div><!-- content -->
	    </div><!-- dialog -->
	</div>
</template>

<script>
import ModelRows     from 'AdminPartialsModal/ModelRows.vue';
import TableControllers     from 'AdminPartials/Components/Controllers/TableControllers.vue'     ;

export default {
	name:'QuickViewModal',
	components:{
			ModelRows,TableControllers
	},
	data( ) { return {
	} } ,
	props : {
	    Columns : Array,
	    CurrentPage : Number,
		SingleTableRows : Object ,
		controller_buttons: Array
	},
}
</script>
