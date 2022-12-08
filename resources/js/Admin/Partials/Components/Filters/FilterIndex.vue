<template>
	<b-input-group :prepend="Factorylable"   class="">

		<FilterInputString
			v-if= "
				FactoryType === 'Router' || 
				FactoryType === 'String'
			"
			:PropLable = "Factorylable"
			:PropPlaceholder = "FactoryPlaceholder"
			:PropType = "'text'"
			:PropName = "FactoryName"
			@change      = "change"
			v-model      = "data"

		/>
		<FilterInputDate
		 	v-if= "FactoryType === 'Date'"
		     :PropLable = "Factorylable"
		     :PropPlaceholder = "FactoryPlaceholder"
		     :PropType = "'date'"
		     :PropName = "FactoryName"
		     @change      = "change"
		     v-model      = "data"
		 /> 
  			
	</b-input-group>

</template>


<script>
import FilterInputString     from 'AdminPartials/Components/Filters/FilterInputString.vue';
import FilterInputDate     from 'AdminPartials/Components/Filters/FilterInputDate.vue';

export default {

	data( ) { return {
		data : this.value,

	} } ,
	components : {
	    FilterInputString,FilterInputDate
	} ,
	props   : {
		Factorylable : 			{  default                       : ''        } ,
		// FactoryForloop : 		{ default                    : ''        } ,
		
		FactoryPlaceholder : 	{  default                       : ''        } ,
		FactoryType : 			{  default                       : ''        } ,
		FactoryName :  			{  default                       : ''        } ,
		value       : 			null,


		FactorySelectOptions			:[] ,

		FactorySelectStrings			:  [] ,
		FactorySelectForloopStrings		:  [] ,
		FactorySelectForloopStringKeys	:  [] ,

		FactorySelectImages				:  [] ,
		FactorySelectForloopImages		:  [] ,
		FactorySelectForloopImageKeys   :  [] ,
	} ,
	watch   : {
		value( ) {
						console.log(this.value);

		    this.data = this.value ;
		}
	} ,
	methods : {
	    change( data ) {
	    	this.data = data
	        this.$emit( 'input'  ,  this.data   ) ;
	        this.$emit( 'change'  ,  this.data   ) ;
	    }
	} 
}
</script>

