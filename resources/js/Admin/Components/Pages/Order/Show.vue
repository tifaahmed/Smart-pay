<template>
    <div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">


					<!-- row -->
					<div class="row row-sm">
						<div class="col-md-12 col-xl-12">
							<div class=" main-content-body-invoice">
								<div class="card card-invoice">
									<div class="card-body">
										<div class="invoice-header">
											<h1 class="invoice-title">Invoice</h1>
											<div class="billed-from">

                                                <h6>{{site_name}}</h6>
                                                Tel No: {{site_phone}}<br>
                                                Email: {{site_email}}

 											</div><!-- billed-from -->
										</div><!-- invoice-header -->
										<div class="row mg-t-20">
											<div class="col-md-5">
												<label class="tx-gray-600">Billed To</label>
												<div class="billed-to">
													<h6>{{order_information.user_full_name}} </h6>
													<p>
                                                        <b>address: </b>  {{order_information.address}} ,
                                                        <br>
                                                        <b>department: </b>{{order_information.department}},
                                                        <br>
                                                        <b>house: </b>{{order_information.house}},
                                                        <br>
                                                        <b>street: </b>{{order_information.street}},
                                                        <br>
                                                        <b>note: </b>{{order_information.note}},
                                                        <br>
                                                        <b>type: </b>{{order_information.type}},
                                                        <br>
                                                        <b>city name: </b>{{order_information.city_name}},
                                                        <br>
													    <b> Phone No: </b> {{order_information.phone}}
                                                        <br>
													    <b> Email: </b>  {{order_information.email}}
                                                    </p>
												</div>
											</div>
											<div class="col-md-7">
												<label class="tx-gray-600">Invoice Information</label>
												<p class="invoice-info-row"><span>Invoice No</span> <span>{{order.order_code}}</span></p>
												<p class="invoice-info-row"><span>status</span> <span>{{order.order_status}}</span></p>
												<p class="invoice-info-row"><span>payment card status:</span> <span>{{order.payment_card_status}}</span></p>
												<p class="invoice-info-row"><span>payment type:</span> <span>{{order.payment_type}}</span></p>
												<p class="invoice-info-row"><span>created_at:</span> <span>{{order.created_at}}</span></p>

												<h4 class="invoice-info-row"><span>stores sub totals:</span> <span>{{order.order_store_sub_totals}}</span></h4>
												<h4 class="tx-primary tx-bold"><span>totals:</span> <span>{{order.total}}</span></h4>

											</div>
										</div>


                                        <br><br>
                                            <br><br>
										<div class="row mg-t-20"
                                             v-for="( order_store    , order_store_key ) in order_stores " :key="order_store_key.id"
                                        >
                                            
                                            <p class="tx-center"> store :  <b>{{order_store.store_title}}</b></p>

                                            <div v-if="order_store.coupon_code" class="col-md-2">
                                                <label class="tx-gray-600">store coupon</label>
                                                <div class="billed-to">
                                                    <p>
                                                        <b> title: </b>  {{order_store.coupon_title}} ,
                                                        <br>
                                                        <b> code: </b>  {{order_store.coupon_code}} ,
                                                        <br>
                                                        <b> type : </b>  {{order_store.coupon_discount_type}} ,
                                                        <br>
                                                        <b> discount: </b>  {{order_store.coupon_discount}} ,
                                                        <br>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="table-responsive mg-t-40" :class="order_store.coupon_discount > 0 ?  'col-md-10':'col-md-12'" 
                                            >
                                                <table class="table table-invoice border text-md-nowrap mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="tx-center">product_id</th>
                                                            <th class="tx-center">product_title</th>
                                                            <th class="tx-center"> product_offer </th>
                                                            <th class="tx-center">product_price</th>
                                                            <th class="tx-center">quantity</th>
                                                            <th class="tx-center">extra sub totals</th>
                                                            <th class="tx-center">sub_total</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody 
                                                        v-for="( order_store_item    , order_store_item_key ) in order_store.order_items " :key="order_store_item_key.id"
                                                    >
                                                        <tr>
                                                            <td class="tx-center">{{order_store_item.product_id}}</td>
                                                            <td class="tx-center">{{order_store_item.product_title}}</td>
                                                            <td class="tx-center">%{{order_store_item.product_offer}}</td>
                                                            <td class="tx-center">{{order_store_item.product_price}}</td>
                                                            <td class="tx-center">{{order_store_item.quantity}}</td>
                                                            <td class="tx-center">{{order_store_item.order_item_extra_sub_totals}}</td>
                                                            <td class="tx-center">{{order_store_item.sub_total}}</td>
                                                        </tr>
                                                        <!-- eslint-disable -->
                                                        <tr class="tx-center" :if="order_store_item.order_item_extras">
                                                            <!-- <thead> -->
                                                                <tr   >
                                                                    <th    class="tx-center">extra_id</th>
                                                                    <th     class="tx-center">extra_price</th>
                                                                    <th   class="tx-center">extra_title</th>
                                                                </tr>
                                                            <!-- </thead> -->
                                                            <!-- <tbody> -->
                                                                <tr
                                                                    v-for="( order_item_extra    , order_item_extra_key ) in order_store_item.order_item_extras " :key="order_item_extra_key"
                                                                >
                                                                    <td   class="tx-center">{{order_item_extra.extra_id}}</td>
                                                                    <td    class="tx-center">{{order_item_extra.extra_price}}</td>
                                                                    <td     class="tx-center">{{order_item_extra.extra_title}}</td>
                                                                </tr>
                                                            <!-- </tbody > -->

                                                        </tr>
                                                        <!-- eslint-disable -->

                                                    </tbody>
                                                    <tr>
                                                            <td class="valign-middle" colspan="2" rowspan="4">
                                                                <div class="invoice-notes">
                                                                    <label class="main-content-label tx-13">store note</label>
                                                                    <p>{{order_store.store_note}}</p>
                                                                </div> 
                                                            </td>
                                                            <td class="tx-right" colspan="2">order item sub totals</td>
                                                            <td class="tx-right" colspan="4">{{order_store.order_item_sub_totals}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tx-right" colspan="2">delevery fee</td>
                                                            <td class="tx-right" colspan="4">{{order_store.delevery_fee}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tx-right" colspan="2">coupon discount</td>
                                                            <td class="tx-right" colspan="4">-{{order_store.coupon_discount}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tx-right tx-uppercase tx-bold tx-inverse" colspan="2">sub total</td>
                                                            <td class="tx-right" colspan="4">
                                                                <h4 class="tx-primary tx-bold">{{order_store.sub_total}}</h4>
                                                            </td>
                                                        </tr>




                                                        





                                                </table>
                                            </div>
										</div>








										<hr class="mg-b-40">
										<a class="btn btn-purple float-left mt-3 mr-2" href="">
											<i class="mdi mdi-currency-usd ml-1"></i>Pay Now
										</a>
										<a href="#" class="btn btn-danger float-left mt-3 mr-2"  onclick="javascript:window.print();">
											<i class="mdi mdi-printer ml-1"></i>Print
										</a>
										<a href="#" class="btn btn-success float-left mt-3">
											<i class="mdi mdi-telegram ml-1"></i>Send Invoice
										</a>
									</div>
								</div>
							</div>
						</div><!-- COL-END -->
					</div>
					<!-- row closed -->



                        <router-link style="color:#fff" 
                            :to = "{ 
                                name : TablePageName , 
                                query: { CurrentPage: this.$route.query.CurrentPage }  
                            }" >                         
                            <button type="button" class="btn btn-danger  ">
                                <i class="fas fa-arrow-left">
                                        back
                                </i>
                            </button>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Model     from 'AdminModels/OrderModel';
import SiteSetting     from 'AdminModels/SiteSettingModel';

import ColumsIndex          from 'AdminPartials/Components/colums/ColumsIndex.vue'     ;

export default {
    name:"Order"+"Show",

    mounted() {
        this.initial();
        this.tableColumns();
    },
    components:{
        ColumsIndex
    },
    data( ) { return {
        TableName :'',
        TablePageName :'Order.All',

        Columns :  [],
        order : {},
        order_information : {},
        order_stores : [],

        site_name : null,
        site_phone : null,
        site_email : null,
        
    } 
    } ,
    methods : {

        // get data
            async initial( ) {
                this.order  = ( await this.Show(this.$route.params.id) ) .data.data[0] ;

                var site_setting  = ( await this.AllSiteSetting() ).data.data ;

                this.site_name = site_setting[2]['item'];
                this.site_email = site_setting[5]['item'];
                this.site_phone = site_setting[6]['item'];


                this.order_information = this.order.order_information
                this.order_stores = this.order.order_stores
            },
        // get data

        async tableColumns(){
            this.Columns = [];
        },

        
        // modal
            AllSiteSetting(){
                return  (new SiteSetting).all()  ;
            },
            async Show(id) {
                return  ( (new Model).show(id) )
            },
        // modal
    }       
}
</script>
