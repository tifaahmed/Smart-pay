<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;

// Resource
use App\Http\Resources\Mobile\Collections\OrderCollection as ModelCollection;
use App\Http\Resources\Mobile\Order\OrderResource as ModelResource;

// lInterfaces
use App\Repository\OrderRepositoryInterface as ModelInterface;
use App\Repository\OrderInformationRepositoryInterface ;
use App\Repository\OrderItemRepositoryInterface  ;
use App\Repository\OrderItemExtraRepositoryInterface  ;
use App\Repository\OrderStoreRepositoryInterface;

use App\Models\OrderItemExtra;
use App\Models\ProductItem;
use App\Models\Extra;
use App\Models\Coupon;

// Requests
use App\Http\Requests\Api\Mobile\Order\OrderStoreApiRequest as modelInsertRequest;
use App\Http\Requests\Api\Mobile\Order\OrderUpdateApiRequest as modelUpdateRequest;


class OrderController extends Controller
{
    private $Repository;
    private $OrderInformationRepository;
    private $OrderItemRepository;
    private $OrderItemExtraRepository;
    private $OrderStoreRepository;
    
    public function __construct(
        ModelInterface $Repository,
        OrderInformationRepositoryInterface $OrderInformationRepository,
        OrderItemRepositoryInterface $OrderItemRepository,
        OrderItemExtraRepositoryInterface $OrderItemExtraRepository,
        OrderStoreRepositoryInterface $OrderStoreRepository
    )
    {
        $this->ModelRepository = $Repository;
        $this->OrderInformationRepository = $OrderInformationRepository;
        $this->OrderItemRepository = $OrderItemRepository;
        $this->OrderItemExtraRepository = $OrderItemExtraRepository;
        $this->OrderStoreRepository = $OrderStoreRepository;
        
        $this->default_per_page = 10;
    }
    
    public function all(){
        try {
            $modal =    $this->ModelRepository->all()    ;
            return new ModelCollection($modal);
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }
    
    public function collection(Request $request){
        try {
            $modal = $this->ModelRepository->collection( $request->per_page ?? $this->default_per_page);
            return new ModelCollection($modal);
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function store(modelInsertRequest $request) {
        $request_order_items = $request->order_items;

        // try {
            // ///////////////////////////////////////1//////////////////////////////
                // enter all order data without 
                // sent payment_type
                // return order row
                $order_model = $this->ModelRepository->custome_create($request->payment_type);
            // ///////////////////////////////////////1//////////////////////////////

            // ///////////////////////////////////////2//////////////////////////////
                //  all related stores
                $store_models = $this->get_store_models($request_order_items);
                

                foreach ($store_models as $key => $store_model) {

                    $coupon_model = Coupon::where('id',$request->coupon_id)->where('store_id',$store_model->id)->first();
                    
                    // sent order_id (parent), store_model(get info) , coupon_model(get info)
                    $order_store_model = $this->OrderStoreRepository->custome_create($order_model->id,$store_model,$coupon_model);
                    
                    // order_items create
                    foreach ($request_order_items as  $order_item) {

                        $product_item_model = ProductItem::find($order_item['product_id']);
                        // sent store_id(parent),product_model(get info),quantity of every product
                        $order_item_model = $this->OrderItemRepository->custome_create($order_store_model->id,$product_item_model,$order_item['quantity']);

                        // create order_item_extras
                        if ( isset($order_item['extra_ids']) ) {
                            foreach ($order_item['extra_ids'] as  $extra_id) {
                                $extra_model = Extra::find($extra_id);
                                // sent order_item_id , extra_model  
                                $order_item_extra =$this->OrderItemExtraRepository->custome_create($order_item_model->id,$extra_model);
                            }
                        } 

                        $order_item_model->update([
                            'order_item_extra_sub_totals'=>$order_item_model->order_item_extras->sum('sub_total'),
                            'sub_total'=> $order_item_model->sub_total + $order_item_model->order_item_extras->sum('sub_total')
                        ]);
                    }

                    $order_item_sub_totals = $order_store_model->order_items->sum('sub_total');

                    $discount_number = $this->get_calculated_discount($coupon_model,$order_item_sub_totals) ?? 0 ;
                    $after_discount  = $order_item_sub_totals - $discount_number ;

                    $order_item_sub_totals = $after_discount < 0 ? 0 : $after_discount;
                    $sub_total = $order_item_sub_totals + $order_store_model->delevery_fee  ;

                    $order_store_model->update([
                        'coupon_discount'=>$discount_number ,
                        'order_item_sub_totals'=>$order_item_sub_totals ,
                        'sub_total'=>  $sub_total
                    ]);
                }
                $order_model->update([
                    'order_store_sub_totals'=> $order_model->order_stores->sum('sub_total') ,
                    'total'=> $order_model->order_stores->sum('sub_total')
                ]);
            // ///////////////////////////////////////2//////////////////////////////

 
            // ///////////////////////////////////////3//////////////////////////////
                // order_informations create
                $address_modal = Auth::user()->address->find($request->address_id);

                // create order_information rows
                // sent $order_id,$address_modal
                // return order_information_model rows
                $order_information_model = $this->OrderInformationRepository->custome_create($order_model->id,$address_modal);
            // ///////////////////////////////////////3//////////////////////////////




            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $order_model ) ],
                'Successful'               ,
                Response::HTTP_OK
            ) ;
        // } catch (\Exception $e) {
        //     return $this -> MakeResponseErrors(  
        //         [$e->getMessage()  ] ,
        //         'Errors',
        //         Response::HTTP_BAD_REQUEST
        //     );
        // }
    }
    public function update(modelUpdateRequest $request ,$id) {
        try {
            $old_model =  $this->ModelRepository->findById($id)  ;
            $all = $this->update_files(
                $old_model,
                $request,
                $this->folder_name,
                $this->file_columns
            );

            $this->ModelRepository->update( $id,Request()->except($this->file_columns)+$all) ;
            $model =  $this->ModelRepository->findById($id) ;

            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $model ) ],
                    'Successful' ,
                    Response::HTTP_OK
            ) ;
            } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        } 
    }

    public function show($id) {
        try {
            $model = $this->ModelRepository->findById($id);
            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $model ) ],
                'Successful',
                Response::HTTP_OK
            ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }



}

