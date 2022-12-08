import Vue from 'vue'

export default class DataService {
	static FilterData = {}  ;
	static RequestData = {}  ;
	static ErrorsData  = {}  ;

    static  now(){
        const date = new Date();
        const day = (date.getDate()).toString().padStart(2, '0');
        const month = (date.getMonth()).toString().padStart(2, '0');
        return  date.getFullYear()+'-'+month+'-'+day ;
    }

    // *********************************************
    static  handleFilters(Columns){
        for (var key in Columns) {
            if (Columns[key].searchable) {
                DataService.FilterData[Columns[key].name] = null;
            }
        }
        return DataService.FilterData;
    }
    static  handleColumns(Columns,Languages){
        for (var key in Columns) {
            // this.$set( DataService.RequestData,  Columns[key].name ,1); 
            DataService.RequestData[Columns[key].name] = null;

            if (Columns[key].translatable) {
                DataService.RequestData[Columns[key].name] = [];
                // [ Column : [] ]
                for (var lang_key in Languages) {
                    Vue.set( DataService.RequestData[ Columns[key].name ]   , Languages[lang_key],null ); 
                    
                    DataService.RequestData[ Columns[key].name ][Languages[lang_key]] =  
                    Columns[key].data_value 
                    ? 
                    Columns[key].data_value[Languages[lang_key]] 
                    : 
                    null ;
                    // [Column : [ ar : null en : null]]

                }
            }else{
                DataService.RequestData[Columns[key].name] = Columns[key].data_value;
                // [ Column : null ]
            } 

        }
        return DataService.RequestData;
    }
    static handleErrorColumns(Columns,Languages){
        for (var key in Columns) {
            if (Columns[key].translatable) {
                for (var lang_key in Languages) {
                    Vue.set( DataService.ErrorsData, Columns[key].name+'.'+Languages[lang_key] , null);
                    // DataService.ErrorsData[ Columns[key].name+'.'+Languages[lang_key]] =  null ;
  
                    DataService.ErrorsData[Columns[key].name+'.'+Languages[lang_key]] = [];
                    // [ Column.ar : [] ]
                }
            }else{
                Vue.set( DataService.ErrorsData, Columns[key].name ,null); 
                // DataService.ErrorsData[ Columns[key].name ]  =  null ;
 
                DataService.ErrorsData[Columns[key].name] = null;
            }
        }
        return DataService.ErrorsData;
    }

}
