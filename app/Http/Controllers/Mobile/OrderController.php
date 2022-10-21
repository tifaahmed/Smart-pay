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
use App\Repository\CouponRepositoryInterface;

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
    private $CouponRepository;
    
    public function __construct(
        ModelInterface $Repository,
        OrderInformationRepositoryInterface $OrderInformationRepository,
        OrderItemRepositoryInterface $OrderItemRepository,
        OrderItemExtraRepositoryInterface $OrderItemExtraRepository,
        OrderStoreRepositoryInterface $OrderStoreRepository,
        CouponRepositoryInterface $CouponRepository
    )
    {
        $this->ModelRepository = $Repository;
        $this->OrderInformationRepository = $OrderInformationRepository;
        $this->OrderItemRepository = $OrderItemRepository;
        $this->OrderItemExtraRepository = $OrderItemExtraRepository;
        $this->OrderStoreRepository = $OrderStoreRepository;
        $this->CouponRepository = $CouponRepository;
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

        try {
            //////1  order //////
                // sent payment_type
                //store data without calculate  the prices
                $order_model = $this->ModelRepository->custome_create($request->payment_type);
            //////1  order //////

            //  all related stores
            $store_models = $this->get_store_models($request_order_items);
            
        
            foreach ($store_models as $key => $store_model) {
                // sent coupon_code & store_id
                // get coupon_model to record the Order Stor data    
                                
                $coupon_model = $this->get_store_coupon($store_model->id,$request->coupon_code);
            
                //////2  Coupon //////
                    $coupon_model 
                    ? 
                    $this->CouponRepository->update($coupon_model->id,['usage_counter'=>$coupon_model->usage_counter -1]) 
                    :
                    null;
                //////2  Coupon //////

                //////3  OrderStore //////
                    // sent order_id (parent), store_model(get info) , coupon_model(get info)
                    //store data without calculate  the prices
                    $order_store_model = $this->OrderStoreRepository->custome_create($order_model->id,$store_model,$coupon_model);
                //////3  OrderStore //////

                // order_items create
                foreach ($request_order_items as  $order_item) {
                    //////4  OrderItem //////
                        // sent product_id
                        // get product_item_model to record the Order Item data                    
                        $product_item_model = $this->get_product_item($order_item['product_id']);
                        // sent store_id(parent),product_model(get info),quantity of every product
                        //store data without calculate  the prices
                        $order_item_model = $this->OrderItemRepository->custome_create($order_store_model->id,$product_item_model,$order_item['quantity']);
                    //////4  OrderItem //////
                    // create order_item_extras
                    if ( isset($order_item['extra_ids']) ) {
                        foreach ($order_item['extra_ids'] as  $extra_id) {
                            //////5  OrderItemExtra //////
                                $extra_model = $this->get_extra($extra_id);
                                // sent order_item_id , extra_model 
                                //store data with prices
                                $order_item_extra =$this->OrderItemExtraRepository->custome_create($order_item_model->id,$extra_model);
                            //////5  OrderItemExtra //////
                        }
                    } 
                    //////4  OrderItem //////
                        // sent model (add the prices)
                        //store data with calculated  the prices from OrderItemExtra table
                        $this->OrderItemRepository->custome_update($order_item_model);
                    //////4  OrderItem //////
                }
                //////3  OrderStore //////
                    $order_item_sub_totals = $order_store_model->order_items->sum('sub_total');
                    $discount_number = $this->get_calculated_discount($coupon_model,$order_item_sub_totals) ?? 0 ;
                    $this->OrderStoreRepository->custome_update($order_store_model,$discount_number);
                //////3  OrderStore //////

            }
            //////1  order //////
                $order_model->update([
                    'order_store_sub_totals'=> $order_model->order_stores->sum('sub_total') ,
                    'total'=> $order_model->order_stores->sum('sub_total')
                ]);
            //////1  order //////

            //////5  OrderInformation //////
                // sent address_id
                // get address_modal to record the OrderInformation  data                    
                $address_modal = $this->get_order_address($request->address_id);

                // sent $order_id,$address_modal
                $order_information_model = $this->OrderInformationRepository->custome_create($order_model->id,$address_modal);
            //////5  OrderInformation //////
            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $order_model ) ],
                'Successful'               ,
                Response::HTTP_OK
            ) ;

        } catch (\Exception $e) {
             return $this -> MakeResponseErrors(  
                 [$e->getMessage()  ] ,
                 'Errors',
                 Response::HTTP_BAD_REQUEST
             );
        }
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

