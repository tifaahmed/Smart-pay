<template >
	<span>
		<RouterColumn
		v-if="typeColumn == 'Router'"
		:ValueColumn= "ValueColumn"
		@SendRowData= "SendRowData" 
		/>
		<StringColumn
		v-else-if= "typeColumn == 'String'"
		:ValueColumn= "ValueColumn"
		/>
		<ImageColumn
		v-else-if= "typeColumn == 'Image'"
		:ValueColumn= "ValueColumn"
		/>
		<DateColumn
		v-else-if= "typeColumn == 'Date'"
		:ValueColumn= "ValueColumn"
		/>		
		<ForloopColumn
		v-else-if= "typeColumn == 'Forloop'"
		:ValueColumn= "ValueColumn"
		:LoopOnColumn =  "LoopOnColumn"
		/>
		<ForloopImageColumn
		v-else-if= "typeColumn == 'ForloopImage'"
		:ValueColumn= "ValueColumn"
		:LoopOnColumn =  "LoopOnColumn"
		/>
		<SelectForloopColumn
		v-else-if= "typeColumn == 'SelectForloop'"
		:ValueColumn= "ValueColumn"
		:LoopOnColumn =  "LoopOnColumn"
		/>
		<MultiSelectForloopColumn
		v-else-if= "typeColumn == 'MultiSelectForloopModal'"
		:ValueColumn= "ValueColumn"
		:LoopOnColumn =  "LoopOnColumn"
		/>
		<LinkColumn
		v-else-if= "typeColumn == 'Link'"
		:ValueColumn= "ValueColumn"
		/>
		<ObjectColumn
		v-else-if= "typeColumn == 'Object'"
		:ValueColumn= "ValueColumn"
		/>
	</span>

</template>
<script> 
import RouterColumn     from 'AdminPartials/Components/colums/RouterColumn.vue'     ;
import StringColumn     from 'AdminPartials/Components/colums/StringColumn.vue'     ;
import ImageColumn     	from 'AdminPartials/Components/colums/ImageColumn.vue'     ;
import DateColumn     	from 'AdminPartials/Components/colums/DateColumn.vue'     ;
import ForloopColumn    from 'AdminPartials/Components/colums/ForloopColumn.vue'     ;
import ForloopImageColumn    from 'AdminPartials/Components/colums/ForloopImageColumn.vue'     ;
import SelectForloopColumn    from 'AdminPartials/Components/colums/SelectColumn/SelectForloopColumn.vue'     ;
import MultiSelectForloopColumn    from 'AdminPartials/Components/colums/MultiSelectForloopColumn/SelectForloopColumn.vue'     ;

import LinkColumn     	from 'AdminPartials/Components/colums/LinkColumn.vue'     ;
import ObjectColumn     	from 'AdminPartials/Components/colums/ObjectColumn.vue'     ;
 
export default {
		name:'ColumsIndex',
    data( ) { return {

    } } ,
    components : {
        RouterColumn ,
		StringColumn,
		ImageColumn,DateColumn,
		ForloopColumn,LinkColumn,
		ObjectColumn,ForloopImageColumn,SelectForloopColumn,MultiSelectForloopColumn
    } ,
    props   : {ValueColumn :null,LoopOnColumn:[],typeColumn :String} ,
    methods : {
        SendRowData( ) {
            this.$emit( 'SendRowData') ;
        }
    } 
} </script>