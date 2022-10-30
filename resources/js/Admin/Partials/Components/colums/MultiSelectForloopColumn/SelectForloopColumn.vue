<template>
    <div>
         
        <b-button v-b-modal="modal_id" variant="outline-primary" > modal</b-button>
        <b-modal :id="modal_id" title="BootstrapVue" centered  >
            <div  v-for="( RowVal , Rowkey )  in ValueColumn" :key="Rowkey"   >
                <div  v-for="( valLoop , Loopkey )  in LoopOnColumn" :key="Loopkey"   >
                    <div v-if="valLoop && RowVal  && RowVal[valLoop.name] !== 'null'" style="    text-align: center;"> 
                        <ColumsIndex  
                            :ValueColumn="RowVal[valLoop.name]"   
                            :typeColumn="valLoop.type" 
                            :LoopOnColumn="valLoop.secondLoopOnColumn"
                        />
                    </div>
                </div> 
            </div>
        </b-modal>
    </div>
</template>

<script> 
import ColumsIndex          from './ColumsIndex.vue'     ;

export default {
    name:"SelectForloopColumn",
    components:{
       ColumsIndex
    },

    data( ) { return {
        modal_id : 'model_'+this.randomNumber()
     } } ,

    props   : {
        ValueColumn :null,
        LoopOnColumn :[],
    } ,
    methods : {
        randomNumber : function(){
        return Math.floor(Math.random() * (10000 - 1 + 1)) + 1;
        }
    }
} </script>